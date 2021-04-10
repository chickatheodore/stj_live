<?php

namespace App\Jobs;

use App\Member;
use App\Transaction;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class ProcessMember implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The member instance.
     *
     * @var Member
     */
    protected $member;
    protected $operation;
    protected $date;

    /**
     * Create a new job instance.
     *
     * @param Member $member
     * @param $operation
     * @return void
     */
    public function __construct(Member $member, $operation)
    {
        $this->member = $member;
        $this->operation = $operation;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->date = Carbon::now()->format('Y-m-d') . ' 00:00:00';
        /*
        $ops = $this->operation;
        if ($ops == 'level')
            $this->processMemberLevel();
        else if ($ops == 'overdue')
            $this->processOverdueMember();
        else if ($ops == 'bonus')
            $this->processMemberBonus();
        */

        $this->processOverdueMember();
        $this->processMemberBonus();
    }

    function processOverdueMember()
    {
        //$now = Carbon::now()->format('Y-m-d') . ' 00:00:00';

        //$find_expired_tupo = 'SELECT * FROM members WHERE close_point_date < :now' . $now;

        DB::statement('INSERT INTO transactions (member_id, user_id, type, trans,
            left_point_beginning_balance, right_point_beginning_balance, left_point_amount, right_point_amount,
            left_point_ending_balance, right_point_ending_balance, status_id)
        SELECT id, 1 AS user_id, \'point\' AS TYPE, \'OVERDUE\' AS trans, left_point AS left_point_beginning_balance,
            right_point AS right_point_beginning_balance,
            -(left_point) AS left_point_amount, -(right_point) AS right_point_amount, 0 AS left_point_ending_balance,
            0 AS right_point_ending_balance, 3 AS status_id
        FROM members
        WHERE close_point_date < :now', array('now' => $this->date));

        DB::statement('UPDATE members SET left_point = 0, right_point = 0 WHERE close_point_date < :now', array('now' => $this->date));

    }

    private function processMemberBonus()
    {
        //$this->member->level->point_value
        $new_members = Member::where('is_new_member', '=', '1')
            ->whereNotNull('level_id')->whereNotNull('upline_id')->get();

        foreach ($new_members as $new_member) {
            $upline = $new_member->upLine;

            //Cari Tree Level untuk Member baru, dan set is_new_member = false
            $new_member->tree_level = $upline->tree_level + 1;
            $new_member->is_new_member = 0;
            $new_member->tree_position = $this->setMemberPosition($new_member, $upline);
            $new_member->save();

            //Berikan bonus untuk sponsor, untuk
            if ($new_member->sponsor_id !== null)
                $this->createSponsorBonus($upline);

            $uid = $new_member->upline_id;
            $temp_member = $new_member;

            //Jelajah sampai level teratas
            while ($uid > 0)
            {
                $position = 'left';

                //Ubah Poin ke Bonus Poin
                if ($upline->left_point > 0 && $upline->right_point > 0)
                    $upline = $this->convertPointToBonusPoint($upline);

                $this->processUpline($upline, $temp_member, $position);

                //Bonus Pasangan
                //if ($upline->left_downline_id != null && $upline->right_downline_id)
                //{
                    $this->createPairBonus($upline, $new_member);
                //}

                if ($upline->upline_id == null)
                    $uid = 0;
                else {
                    $upline = $upline->upLine;
                }

                $temp_member = $upline;
            }
        }
    }

    private function setMemberPosition($member, $upline)
    {
        $position = 0;
        if ($upline->left_downline_id == $member->id) {
            $kiri = floatval($upline->tree_position);
            $position = ($kiri * 2) - 1;
        } elseif ($upline->right_downline_id == $member->id) {
            $kanan = floatval($upline->tree_position);
            $position = ($kanan * 2);
        }
        return $position;
    }

    private function processUpline($upline, $downline, $position)
    {
        $transaction = Transaction::where('transaction_date', '=', $this->date)
            ->where('member_id', '=', $upline->id)->where('type', '<>', 'pin')
            //->where('trans', '<>', 'PAYMENT')
            ->get();

        if ($transaction === null) {
            $transaction = new Transaction();

            $transaction->member_id = $upline->id;
            $transaction->user_id = 1;
            $transaction->type = 'all';
            $transaction->trans = 'SYSTEM';
        }

        //Upline dapat Bonus Point (untuk member baru)
        if ($upline->left_downline_id == $downline->id) {
            $upline->left_point = $upline->left_point + 25;
        }

        if ($upline->right_downline_id == $downline->id) {
            $position = 'right';
            $upline->right_point = $upline->right_point + 25;
        }

        $upline->save();

        //Berikan Bonus untuk Upline
        $transaction = $this->createPointBonus($upline, $transaction, $position);
        $transaction->save();
    }

    private function createPointBonus($upline, $transaction, $position)
    {
        $transaction->left_point_amount = 0;
        $transaction->right_point_amount = 0;

        $transaction->left_point_beginning_balance = $upline->left_point;
        $transaction->right_point_beginning_balance = $upline->right_point;

        if ($position == 'left') {
            $transaction->left_point_amount = 25;
        } elseif ($position == 'right') {
            $transaction->right_point_amount = 25;
        }

        $transaction->left_point_ending_balance = $transaction->left_point_beginning_balance + $transaction->left_point_amount;
        $transaction->right_point_ending_balance = $transaction->right_point_beginning_balance + $transaction->right_point_amount;

        return $transaction;
    }

    private function convertPointToBonusPoint($upline)
    {
        $max = 0;
        if ($upline->left_point >= $upline->right_point)
            $max = $upline->right_point;
        elseif ($upline->left_point < $upline->right_point)
            $max = $upline->left_point;

        $jumlah_point = ($max * 2) / 25;

        $faktor_kali = intval($upline->level->minimum_point);
        $nilai_point = floatval($upline->level->point_value);

        $transaction = Transaction::where('transaction_date', '=', $this->date)
            ->where('member_id', '=', $upline->id)->where('type', '<>', 'pin')
            //->where('trans', '<>', 'PAYMENT')
            ->get();

        if ($transaction === null) {
            $transaction = new Transaction();

            $transaction->member_id = $upline->id;
            $transaction->user_id = 1;
            $transaction->type = 'all';
            $transaction->trans = 'SYSTEM';
        }

        $transaction->bonus_point_amount = $jumlah_point * ($faktor_kali * $nilai_point);
        $transaction->save();

        $upline->left_point = $upline->left_point - $max;
        $upline->right_point = $upline->right_point - $max;
        $upline->save();

        return $upline;
    }

    private function createSponsorBonus($upline)
    {
        $transaction = Transaction::where('transaction_date', '=', $this->date)
            ->where('member_id', '=', $upline->id)->where('type', '<>', 'pin')
            //->where('trans', '<>', 'PAYMENT')
            ->get();

        if ($transaction === null) {
            $transaction = new Transaction();

            $transaction->member_id = $upline->id;
            $transaction->user_id = 1;
            $transaction->type = 'all';
            $transaction->trans = 'SYSTEM';
        }

        $faktor_kali = intval($upline->level->minimum_point);
        $nilai_point = floatval($upline->level->point_value);

        $transaction->bonus_sponsor_amount = $faktor_kali * $nilai_point;
        $transaction->save();
    }

    private function createPairBonus($upline, $new_member)
    {
        //Set batasan maksimal kedalaman
        $amount = $this->getPairAmount($upline, $new_member);

        if ($amount === 0)
            return;

        //Cari pasangan dari semua downline pada level $my_level
        $upline_level = $upline->tree_level;
        $my_tree_level = $new_member->tree_level;

        $position = floatval($upline->tree_position);
        $my_position = floatval($new_member->tree_position);

        $selisih = $my_tree_level - $upline_level;

        $node_counts = 2 ^ $selisih;
        $start = ($node_counts * ($position - 1)) + 1;
        $end = ($start + $node_counts) - 1;

        $setengah = $node_counts / 2;
        $kiri_akhir = $end - $setengah;

        $pasangan = null;   //new Member();

        //Jika posisi = Kiri
        if ($my_position <= $kiri_akhir)
        {
            $kiri = (($end - $my_position) - $setengah) + 1;    //Penomoran
            $kanan = $kiri + $kiri_akhir;

            $pasangan = Member::where('tree_level', '=', $my_tree_level)->where('tree_position', '=', $kanan);

        } elseif ($my_position > $kiri_akhir) {
            $kanan = $setengah - ($end - $my_position);
            $kiri = $kanan + $kiri_akhir;

            $pasangan = Member::where('tree_level', '=', $my_tree_level)->where('tree_position', '=', $kiri);
        }

        if ($pasangan !== null)
        {
            $faktor_kali = intval($upline->level->minimum_point);
            $nilai_point = $amount; //floatval($upline->level->point_value);

            $transaction = Transaction::where('transaction_date', '=', $this->date)
                ->where('member_id', '=', $upline->id)->where('type', '<>', 'pin')
                //->where('trans', '<>', 'PAYMENT')
                ->get();

            if ($transaction === null) {
                $transaction = new Transaction();

                $transaction->member_id = $upline->id;
                $transaction->user_id = 1;
                $transaction->type = 'all';
                $transaction->trans = 'SYSTEM';
            }

            $transaction->bonus_partner_amount = $faktor_kali * $nilai_point;
            $transaction->save();
        }

    }

    private function getPairAmount($upline, $new_member)
    {
        $amount = 0;
        /*$pair_formulas = [
            '1' => [
                [ 'from' => 1, 'to' => 20, 'amount' => 55000 ],
                [ 'from' => 21, 'to' => 999999999, 'amount' => 0 ],
            ],
            '2' => [
                [ 'from' => 1, 'to' => 35, 'amount' => 65000 ],
                [ 'from' => 36, 'to' => 70, 'amount' => 30000 ],
                [ 'from' => 71, 'to' => 100, 'amount' => 20000 ],
                [ 'from' => 101, 'to' => 999999999, 'amount' => 0 ],
            ]
        ];*/

        $up_level = $upline->tree_level;
        $my_level = $new_member->tree_level;
        $selisih_level = $my_level - $up_level;

        $m_level = $new_member->level_id;
        if ($m_level == 1)
        {
            if ($selisih_level > 0 && $selisih_level <= 20)
                $amount = 55000;
        } else if ($m_level == 2) {
            if ($selisih_level >= 1 && $selisih_level <= 35)
                $amount = 65000;
                if ($selisih_level >= 36 && $selisih_level <= 70)
                $amount = 30000;
                if ($selisih_level >= 71 && $selisih_level <= 100)
                $amount = 20000;
        }

        return $amount;
    }

    /*
     * NOT USED
     */

    private function initTransaction($upline)
    {
        $transaction = new Transaction();

        $transaction->member_id = $upline->id;
        $transaction->user_id = 1;
        $transaction->type = 'point';
        $transaction->trans = 'POINT';

        return $transaction;
    }

    private function processMemberLevel()
    {
        //Pastikan user harus punya 1 poin biar bisa ditempatkan
        if (!$this->member->pin)
            return;

        //Mencari level untuk member baru, serta update jumlah member kiri atau kanan

        $upline = $this->member->upLine;
        $upline_level = $upline->tree_level;

        $this->member->tree_level = $upline_level++;

        while ($upline_level > 0) {

            //cari posisi member baru, kiri apa kanan
            if ($this->member->id == $upline->left_downline_id)
                $upline->left_downline_count++;
            else if ($this->member->id == $upline->right_downline_id)
                $upline->right_downline_count++;

            $upline->save();

            $upline = $upline->upLine;
            $upline_level = $upline->tree_level;
        }
    }

    private function processOverdueMemberOld()
    {
        $this->member->left_point = 0;
        $this->member->right_point = 0;

        //$this->member->left_bonus_partner = 0;
        //$this->member->right_bonus_partner = 0;

        $this->member->save();

        $left_beginning = intval($this->member->left_point);
        $left_amount = 0 - $left_beginning;
        $right_beginning = intval($this->member->right_point);
        $right_amount = 0 - $right_beginning;

        $last_trans = Transaction::orderBy('transaction_date', 'DESC')->first();
        if ($last_trans)
        {
            if ($last_trans->type !== 'point' && $last_trans->trans !== 'OVERDUE')
            {
                Transaction::create([
                    'member_id' => $this->member->id,
                    'user_id' => 1,
                    'type' => 'point',
                    'trans' => 'OVERDUE',
                    'left_point_beginning_balance' => $left_beginning,
                    'right_point_beginning_balance' => $right_beginning,
                    'left_point_amount' => $left_amount,
                    'right_point_amount' => $right_amount,
                    'left_point_ending_balance' => 0,
                    'right_point_ending_balance' => 0,
                    'status_id' => 3
                ]);
            }
        }

    }

}
