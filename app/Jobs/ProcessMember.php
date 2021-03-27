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
        $now = Carbon::now()->format('Y-m-d') . ' 00:00:00';

        //$find_expired_tupo = 'SELECT * FROM members WHERE close_point_date < :now' . $now;

        DB::statement('INSERT INTO transactions (member_id, user_id, type, trans, 
            left_point_beginning_balance, right_point_beginning_balance, left_point_amount, right_point_amount,
            left_point_ending_balance, right_point_ending_balance, status_id)
        SELECT id, 1 AS user_id, \'point\' AS TYPE, \'OVERDUE\' AS trans, left_point AS left_point_beginning_balance, 
            right_point AS right_point_beginning_balance,
            -(left_point) AS left_point_amount, -(right_point) AS right_point_amount, 0 AS left_point_ending_balance, 
            0 AS right_point_ending_balance, 3 AS status_id
        FROM members
        WHERE close_point_date < :now', array('now' => $now));

        DB::statement('UPDATE members SET left_point = 0, right_point = 0 WHERE close_point_date < :now', array('now' => $now));

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
            $new_member->save();

            $my_level = $new_member->tree_level;

            //Buat Transaksi untuk Upline
            $transaction = $this->initTransaction($upline);

            //Berikan bonus untuk sponsor, untuk
            if ($new_member->sponsor_id !== null)
            {
                $transaction = $this->createSponsorBonus($upline, $transaction);
            }

            $uid = $new_member->upline_id;
            $temp_member = $new_member;

            //Jelajah sampai level teratas
            while ($uid > 0)
            {
                $position = 'left';

                $transaction = $this->processUpline($transaction, $temp_member, $upline, $position);

                if ($upline->left_downline_id != null && $upline->right_downline_id)
                {
                    //Bonus Pasangan
                    $transaction = $this->createPartnerBonus($upline, $transaction, $my_level);
                }

                $transaction->save();

                if ($upline->upline_id == null)
                    $uid = 0;
                else {
                    $upline = $upline->upLine;
                    $transaction = $this->initTransaction($upline);
                }

                $temp_member = $upline;
            }
        }
    }

    private function processUpline($transaction, $downline, $upline, $position)
    {
        //Upline dapat Bonus Point (untuk member baru)
        if ($upline->left_downline_id == $downline->id)
            $upline->left_point = $upline->left_point + 25;

        if ($upline->right_downline_id == $downline->id) {
            $position = 'right';
            $upline->right_point = $upline->right_point + 25;
        }

        //Berikan Bonus untuk Upline
        $transaction = $this->createPointBonus($upline, $transaction, $position);

        return $transaction;
    }

    private function initTransaction($upline)
    {
        $transaction = new Transaction();

        $transaction->member_id = $upline->id;
        $transaction->user_id = 1;
        $transaction->type = 'point';
        $transaction->trans = 'POINT';

        return $transaction;
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

    private function createSponsorBonus($upline, $transaction)
    {
        $faktor_kali = intval($upline->level->minimum_point);
        $nilai_point = floatval($upline->level->point_value);

        $transaction->bonus_sponsor_amount = $faktor_kali * $nilai_point;
        return $transaction;
    }

    private function createPartnerBonus($upline, $transaction, $my_level)
    {
        //Cari pasangan dari semua downline pada level $my_level

        $faktor_kali = intval($upline->level->minimum_point);
        $nilai_point = floatval($upline->level->point_value);

        $transaction->bonus_partner_amount = $faktor_kali * $nilai_point;
        return $transaction;
    }

    /*
     * NOT USED
     */

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
