<?php

namespace App\Jobs;

use App\Member;
use App\Transaction;
use App\TempTransaction;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Log;

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

    protected $mode;
    protected $date;
    protected $high_date;

    /**
     * Create a new job instance.
     *
     * @param Member $member
     * @param $operation
     * @return void
     */
    public function __construct()   /*Member $member, $operation*/
    {
        //$this->member = $member;
        //$this->operation = $operation;

        //options : no_point, with_point
        $this->mode = 'with_point';

        $arguments = func_get_args();
        $numberOfArguments = func_num_args();
        if (method_exists($this, $function = '__construct'.$numberOfArguments)) {
            call_user_func_array(array($this, $function), $arguments);
        }
    }

    public function __construct1($mode)
    {
        $this->mode = $mode;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->date = Carbon::now()->format('Y-m-d') . ' 00:00:00';
        $this->high_date = Carbon::now()->format('Y-m-d') . ' 23:59:59';

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

    private function skipMember($member)
    {
        $now = Carbon::now();
        $close_date = Carbon::parse($member->close_point_date . ' 23:59:59');

        $skip = $member->id == 1 || $now->gt($close_date) || $member->is_tupo === 1 || $member->is_active === 0;

        return $skip;
    }

    function processOverdueMember()
    {
        //$now = Carbon::now()->format('Y-m-d') . ' 00:00:00';

        //$find_expired_tupo = 'SELECT * FROM members WHERE close_point_date < :now' . $now;

        /*
        DB::statement('INSERT INTO transactions (member_id, user_id, type, trans,
            left_point_beginning_balance, right_point_beginning_balance, left_point_amount, right_point_amount,
            left_point_ending_balance, right_point_ending_balance, status_id)
        SELECT id, 1 AS user_id, \'point\' AS TYPE, \'OVERDUE\' AS trans, left_point AS left_point_beginning_balance,
            right_point AS right_point_beginning_balance,
            -(left_point) AS left_point_amount, -(right_point) AS right_point_amount, 0 AS left_point_ending_balance,
            0 AS right_point_ending_balance, 3 AS status_id
        FROM members
        WHERE id > 2 and close_point_date < :now', array('now' => $this->date));

        DB::statement('UPDATE members SET left_point = 0, right_point = 0 WHERE id > 2 and close_point_date < :now', array('now' => $this->date));
        */

        $members = Member::all();
        foreach ($members as $member) {
            if ($member->id > 2 && $member->is_active === 1 && Carbon::parse($member->close_point_date) < Carbon::now())
            {
                $transaction = Transaction::where('member_id', '=', $member->id)->where('trans', '=', 'OVERDUE')->orderByDesc('transaction_date')->first();
                if ($transaction === null) {
                    Transaction::create([
                        'member_id' => $member->id,
                        'user_id' => '1',
                        'type' => 'point',
                        'trans' => 'OVERDUE',
                        'left_point_beginning_balance' => $member->left_point,
                        'right_point_beginning_balance' => $member->right_point,
                        'left_point_amount' => 0 - $member->left_point,
                        'right_point_amount' => 0 - $member->right_point,
                        'left_point_ending_balance' => '0',
                        'right_point_ending_balance' => '0',
                        'status_id' => '3',
                    ]);
                }

                $member->left_point = 0;
                $member->right_point = 0;
                $member->save();
            }

            //jika member punya point kiri dan kanan, ubah ke bonus
            if ($member->id > 2 && $member->is_active === 1 && Carbon::parse($member->close_point_date) >= Carbon::now()) {

                //Ubah Poin ke Bonus Poin
                if ($member->left_point > 0 && $member->right_point > 0)
                    $konversi = $this->convertPointToBonusPoint($member);

            }

        }

        DB::statement('truncate table temp_transactions');
    }

    private function processMemberBonus()
    {
        //DB::statement('insert into transactions (member_id, user_id, type, trans, status_id)
        //    select id, 1 AS user_id, \'all\' AS type, \'SYSTEM\' AS trans, 1 AS status_id from members where id > 2
        //    and is_active = 1 and close_point_date >= :now', array('now' => $this->date));

        /*
         * Member memperoleh bonus jika ada Member baru yang memenuhi syarat :
         * - Sudah diaktifkan
         * - Status : New Member
         * - Punya Level ( BRONZE atau GOLD )
         * - Punya Upline
        */
        $new_members = Member::where('is_tupo', '=', '1')
            ->where('is_active', '=', '1')
            ->whereNotNull('level_id')->whereNotNull('upline_id')->get();

        foreach ($new_members as $new_member) {
            $new_member->refresh();

            $upline = $new_member->upLine;

            //Cari Tree Level untuk Member baru, dan set is_tupo = false
            $new_member->tree_level = $upline->tree_level + 1;
            $new_member->is_tupo = 0;
            $new_member->tree_position = $this->setMemberPosition($new_member, $upline);
            $new_member->save();

            //Berikan bonus untuk sponsor, untuk
            if ($new_member->sponsor_id !== null)
                $this->createSponsorBonus($new_member);

            $uid = $new_member->upline_id;
            $up_id = $new_member->upline_id;

            if ($this->mode === 'with_point')
                $temp_member = $new_member;

            //Jelajah sampai level teratas
            while ($uid > 0)
            {
                $upline = Member::find($up_id);
                if (!$this->skipMember($upline)) {
                    $position = 'left';

                    if ($this->mode === 'with_point') {
                        //Poin downline
                        $this->processUpline($upline, $temp_member, $position, $new_member);
                    }

                    //Bonus Pasangan
                    $this->createPairBonus($upline, $new_member);
                }

                if ($upline->upline_id == null)
                    $uid = 0;
                else {
                    //$upline = $upline->upLine;

                    if ($this->mode === 'with_point') {
                        $temp_member = Member::find($up_id);
                    }

                    $up_id = $upline->upline_id;
                }

                //$temp_member = $upline;
            }

        }

        //Terakhir finalisasi saldo awal, saldo akhir, saldo bonus
        $this->finalizeTransaction();   //$upline

        // Terakhir, pindahkan dari temp ke Transaction
        DB::statement('insert into transactions
        (member_id,user_id,transaction_date,type,trans,pin_beginning_balance,pin_amount,pin_ending_balance,left_point_beginning_balance,right_point_beginning_balance,left_point_amount,right_point_amount,left_point_ending_balance,right_point_ending_balance,bonus_beginning_balance,bonus_point_amount,bonus_sponsor_amount,bonus_partner_amount,bonus_paid_amount,bonus_ending_balance,remarks)
        select member_id,user_id,transaction_date,type,trans,pin_beginning_balance,pin_amount,pin_ending_balance,left_point_beginning_balance,right_point_beginning_balance,left_point_amount,right_point_amount,left_point_ending_balance,right_point_ending_balance,bonus_beginning_balance,bonus_point_amount,bonus_sponsor_amount,bonus_partner_amount,bonus_paid_amount,bonus_ending_balance,remarks from temp_transactions');
    }

    private function getOrCreateTempTransactions($member)
    {
        $now = Carbon::now()->format('Y-m-d h:i:s');
        $start = Carbon::now()->format('Y-m-d') . ' 00:00:00';
        $end = Carbon::now()->format('Y-m-d') . ' 23:59:59';

        $temp_transaction = TempTransaction::where('member_id', '=', $member->id)
            ->whereBetween('transaction_date', [ $start, $end ])
            ->where('trans', '=', 'SYSTEM')->first();

        if ($temp_transaction === null)
        {
            $total_bonus = $member->point_bonus + $member->sponsor_bonus + $member->pair_bonus;
            $temp_transaction = TempTransaction::create(
                [
                    'member_id' => $member->id,
                    'user_id' => '1',
                    'transaction_date' => $now,
                    'type' => 'all',
                    'trans' => 'SYSTEM',
                    'pin_beginning_balance' => $member->pin,
                    'left_point_beginning_balance' => $member->left_point,
                    'right_point_beginning_balance' => $member->right_point,
                    'bonus_beginning_balance' => $total_bonus,
                ]
            );
        }
        return $temp_transaction;
    }

    private function finalizeTransaction()  //$member
    {
        /*$old_transaction = Transaction::where('transaction_date', '<', $this->date)
            ->where('member_id', '=', $member->id)->where('type', '<>', 'pin')
            ->orderByDesc('transaction_date')
            ->first();

        $transaction = Transaction::whereBetween('transaction_date', [ $this->date, $this->high_date])
            ->where('member_id', '=', $member->id)->where('type', '<>', 'pin')
            //->where('trans', '<>', 'PAYMENT')
            ->first();*/

        //$transaction = $this->getOrCreateTempTransactions($member);
        $transactions = TempTransaction::all();

        foreach($transactions as $transaction) //if ($transaction !== null)
        {
            /*if ($old_transaction === null)
                $transaction->bonus_beginning_balance = 0;
            else
                $transaction->bonus_beginning_balance = $old_transaction->bonus_ending_balance;*/

            $member = Member::find($transaction->member_id); //$transaction->member;

            $pb = $transaction->pin_beginning_balance;
            $pa = $transaction->pin_amount;
            $transaction->pin_ending_balance = $pb + $pa;

            $lpb = $transaction->left_point_beginning_balance;
            $rpb = $transaction->right_point_beginning_balance;
            $lp = $transaction->left_point_amount;
            $rp = $transaction->right_point_amount;
            $transaction->left_point_ending_balance = $lpb + $lp;
            $transaction->right_point_ending_balance = $rpb + $rp;

            $bbb = $transaction->bonus_beginning_balance;
            $p = $transaction->bonus_point_amount;
            $s = $transaction->bonus_sponsor_amount;
            $a = $transaction->bonus_partner_amount;
            $i = 0; //$transaction->bonus_paid_amount;

            $balance = ($bbb + ($p + $s + $a)) - abs($i);
            $transaction->bonus_ending_balance = $balance;

            $transaction->remarks = $this->createRemarks($transaction, PHP_EOL . 'SETTING MEMBER DATA');
            $log = null;
            if ($transaction->bonus_point_amount !== null) {
                $mpb = $member->point_bonus;
                $end_pb = $mpb + $transaction->bonus_point_amount;
                $member->point_bonus = $end_pb; //$member->point_bonus + $transaction->bonus_point_amount;

                $transaction->remarks = $this->createRemarks($transaction, 'Bonus Poin : ' . number_format($mpb,0) . ' + ' . number_format($transaction->bonus_point_amount,0) . '= ' . number_format($end_pb,0));
            }
            if ($transaction->bonus_sponsor_amount !== null) {
                $msb = $member->sponsor_bonus;
                $end_sb = $msb + $transaction->bonus_sponsor_amount;
                $member->sponsor_bonus = $end_sb; //$member->sponsor_bonus + $transaction->bonus_sponsor_amount;

                $transaction->remarks = $this->createRemarks($transaction, 'Bonus Sponsor : ' . number_format($msb,0) . ' + ' . number_format($transaction->bonus_sponsor_amount,0) . '= ' . number_format($end_sb,0));
            }
            if ($transaction->bonus_partner_amount !== null) {
                $mib = $member->pair_bonus;
                $end_ib = $mib + $transaction->bonus_partner_amount;
                $member->pair_bonus = $end_ib; //$member->pair_bonus + $transaction->bonus_partner_amount;

                $transaction->remarks = $this->createRemarks($transaction, 'Bonus Pasangan : ' . number_format($mib,0) . ' + ' . number_format($transaction->bonus_partner_amount,0) . '= ' . number_format($end_ib,0));
            }

            $transaction->save();

            $member->save();
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

    private function processUpline($upline, $downline, $position, $new_member)
    {
        /*$transaction = Transaction::whereBetween('transaction_date', [ $this->date, $this->high_date])
            ->where('member_id', '=', $upline->id)->where('type', '<>', 'pin')
            //->where('trans', '<>', 'PAYMENT')
            ->first();*/

        $transaction = $this->getOrCreateTempTransactions($upline);

        if ($transaction === null) {
            $transaction = new TempTransaction();

            $transaction->member_id = $upline->id;
            $transaction->user_id = 1;
            $transaction->type = 'all';
            $transaction->trans = 'SYSTEM';

            /*$last_trans = TempTransaction::where('member_id', '=', $upline->id)->orderByDesc('transaction_date')->first();
            if ($last_trans !== null) {
                $transaction->pin_beginning_balance = $last_trans->pin_ending_balance;
                $transaction->pin_ending_balance = $last_trans->pin_ending_balance;
            }*/
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
        $transaction = $this->createPointBonus($upline, $transaction, $position, $new_member);
        $transaction->save();
    }

    private function createPointBonus($upline, $transaction, $position, $new_member)
    {
        //$transaction->left_point_amount = 0;
        //$transaction->right_point_amount = 0;

        //$transaction->left_point_beginning_balance = $upline->left_point;
        //$transaction->right_point_beginning_balance = $upline->right_point;

        if ($position == 'left') {
            $transaction->left_point_amount = $transaction->left_point_amount + 25;
        } elseif ($position == 'right') {
            $transaction->right_point_amount = $transaction->right_point_amount + 25;
        }

        //$transaction->left_point_ending_balance = $transaction->left_point_beginning_balance + $transaction->left_point_amount;
        //$transaction->right_point_ending_balance = $transaction->right_point_beginning_balance + $transaction->right_point_amount;

        $transaction->remarks = $this->createRemarks($transaction, 'Bonus member baru [ ' . $new_member->code . ' - ' . $new_member->name . ' ] (25 BV).');

        return $transaction;
    }

    private function convertPointToBonusPoint($upline)
    {
        $max = 0;
        $level = $upline->level_id === null ? 'NULL' : ($upline->level_id === 1 ? 'BRONZE' : 'GOLD');

        if ($upline->left_point >= $upline->right_point)
            $max = $upline->right_point;
        elseif ($upline->left_point < $upline->right_point)
            $max = $upline->left_point;

        $jumlah_point = $max / 25; //($max * 2) / 25;

        $faktor_kali = 1;   // Point bonus tidak di kali 8, intval($upline->level->minimum_point);
        $nilai_point = floatval($upline->level->point_value);

        /*$transaction = Transaction::whereBetween('transaction_date', [ $this->date, $this->high_date])
            ->where('member_id', '=', $upline->id)->where('type', '<>', 'pin')
            //->where('trans', '<>', 'PAYMENT')
            ->first();*/

        $transaction = $this->getOrCreateTempTransactions($upline);

        if ($transaction === null) {
            $transaction = new TempTransaction();

            $transaction->member_id = $upline->id;
            $transaction->user_id = 1;
            $transaction->type = 'all';
            $transaction->trans = 'SYSTEM';

            /*$last_trans = TempTransaction::where('member_id', '=', $upline->id)->orderByDesc('transaction_date')->first();
            if ($last_trans !== null) {
                $transaction->pin_beginning_balance = $last_trans->pin_ending_balance;
                $transaction->pin_ending_balance = $last_trans->pin_ending_balance;
            }*/
        }

        $transaction->bonus_point_amount = $jumlah_point * ($faktor_kali * $nilai_point);

        $transaction->remarks = $this->createRemarks($transaction,
            'Ubah bonus point: ' . number_format($max, 0) . ' BV (' . number_format($jumlah_point, 0) . '). Level: ' . $level .
            ', [ (' . number_format($jumlah_point, 0) . ' * ' . number_format($faktor_kali, 0) . ') * ' .
            number_format($nilai_point, 0) . ' ] = ' . number_format($transaction->bonus_point_amount, 0)
        );

        $transaction->save();

        $upline->left_point = $upline->left_point - $max;
        $upline->right_point = $upline->right_point - $max;
        $upline->save();

        return $upline;
    }

    private function createSponsorBonus($new_member)
    {
        $sponsor = $new_member->sponsor;

        /*$transaction = Transaction::whereBetween('transaction_date', [ $this->date, $this->high_date])
            ->where('member_id', '=', $sponsor->id)->where('type', '<>', 'pin')
            //->where('trans', '<>', 'PAYMENT')
            ->first();*/

        $transaction = $this->getOrCreateTempTransactions($sponsor);

        if ($transaction === null) {
            $transaction = new TempTransaction();

            $transaction->member_id = $sponsor->id;
            $transaction->user_id = 1;
            $transaction->type = 'all';
            $transaction->trans = 'SYSTEM';
            //$transaction->bonus_sponsor_amount = 0;

            /*$last_trans = Transaction::where('member_id', '=', $sponsor->id)->orderByDesc('transaction_date')->first();
            if ($last_trans !== null) {
                $transaction->pin_beginning_balance = $last_trans->pin_ending_balance;
                $transaction->pin_ending_balance = $last_trans->pin_ending_balance;
            }*/
        }

        $faktor_kali = 1;   // Sponsor bonus tidak di kali 8, intval($sponsor->level->minimum_point);
        $nilai_point = 80000; //floatval($sponsor->level->point_value);
        $level = $sponsor->level_id === null ? 'NULL' : ($sponsor->level_id === 1 ? 'BRONZE' : 'GOLD');

        $bonus = $faktor_kali * $nilai_point;
        $transaction->bonus_sponsor_amount = $transaction->bonus_sponsor_amount + $bonus;

        $transaction->remarks = $this->createRemarks($transaction,
            'Bonus sponsor dari member baru [ ' . $new_member->code . ' - ' . $new_member->name . ' ].  Level: ' . $level .
            ', [ (' . number_format($faktor_kali, 0) . ') * ' .
            number_format($nilai_point, 0) . ') ] = ' .
            number_format($bonus, 0)
        );

        $transaction->save();
    }

    private function createPairBonus($upline, $new_member)
    {
        //Set batasan maksimal kedalaman
        $amount = $this->getPairAmount($upline, $new_member);

        if ($amount === 0) {
            Log::info('Member ['.$new_member->id.' ('.$new_member->code.' - '.$new_member->name.')]' . PHP_EOL .
            'Amount : 0');
            return;
        }

        //Cari pasangan dari semua downline pada level $my_level
        $upline_level = $upline->tree_level;
        $my_tree_level = $new_member->tree_level;

        $position = floatval($upline->tree_position);
        $my_position = floatval($new_member->tree_position);

        $selisih = $my_tree_level - $upline_level;

        $node_counts = pow(2, $selisih);
        $start = ($node_counts * ($position - 1)) + 1;
        $end = ($start + $node_counts) - 1;

        $setengah = $node_counts / 2;
        $kiri_akhir = $end - $setengah;

        $pasangan = null;   //new Member();
        $cari_posisi = 0;

        //Jika posisi = Kiri
        $is_kiri = true;
        if ($my_position <= $kiri_akhir)
        {
            $kiri = (($end - $my_position) - $setengah) + 1;    //Penomoran
            $kanan = $kiri + $kiri_akhir;
            $cari_posisi = $kanan;

            $pasangan = Member::where('tree_level', '=', $my_tree_level)
                ->where('tree_position', '=', $kanan);
                //->where('is_paired', '=', '0');

        } elseif ($my_position > $kiri_akhir) {
            $is_kiri = false;
            $kanan = $setengah - ($end - $my_position);
            $kiri = $kanan + $kiri_akhir;
            $cari_posisi = $kiri;

            $pasangan = Member::where('tree_level', '=', $my_tree_level)
                ->where('tree_position', '=', $kiri);
                //->where('is_paired', '=', '0');
        }

        $pair = $pasangan->first();

        $log = 'Member : Level = '.$new_member->tree_level.', Posisi = '.$new_member->tree_position.PHP_EOL.
            'Upline : Level = '.$upline->tree_level.', Posisi = '.$upline->tree_position.PHP_EOL.
            'Selisih Level : '.$selisih.', Jumlah Node = '.$node_counts.PHP_EOL.
            'Rentang : '.$start.' s/d '.$end.'. Tengah : '.$end.PHP_EOL.
            'Kiri : '.$start.' -> '.$kiri_akhir.', Kanan : '.($kiri_akhir + 1).' -> '.$end.PHP_EOL.
            'Kiri POS : '.$kiri.', Kanan POS : '.$kanan;

        Log::debug($log);

        /*Log::info('Member ['.$new_member->id.' ('.$new_member->code.' - '.$new_member->name.')]' . PHP_EOL .
            'Upline ['.$upline->id.' ('.$upline->code.' - '.$upline->name.')]' . PHP_EOL .
            'Level : '.$new_member->tree_level.', Position : '.$new_member->tree_position.'.'.PHP_EOL.
            'Pasangan : Level = '.$my_tree_level.', Position : '.$cari_posisi.PHP_EOL.
            'Is Kiri : '.($is_kiri === true ? 'Ya' : 'Tidak').', Kiri : '.$kiri.', Kanan : '.$kanan.PHP_EOL.
            'Ketemu : '.($pair === null ? 'Tidak' : 'Ya, Id : '.$pair->id));*/

        if ($pair !== null && $pair->id !== $new_member->id)
        {
            $pair->is_paired = 1;
            $new_member->is_paired = 1;

            $pair->save();
            $new_member->save();

            $faktor_kali = intval($new_member->level->minimum_point); //intval($upline->level->minimum_point);
            $nilai_point = $amount; //floatval($upline->level->point_value);

            /*$transaction = Transaction::whereBetween('transaction_date', [ $this->date, $this->high_date])
                ->where('member_id', '=', $upline->id)->where('type', '<>', 'pin')
                //->where('trans', '<>', 'PAYMENT')
                ->first();*/

            $transaction = $this->getOrCreateTempTransactions($upline);

            if ($transaction === null) {
                $transaction = new TempTransaction();

                $transaction->member_id = $upline->id;
                $transaction->user_id = 1;
                $transaction->type = 'all';
                $transaction->trans = 'SYSTEM';
                //$transaction->bonus_partner_amount = 0;

                /*$last_trans = Transaction::where('member_id', '=', $upline->id)->orderByDesc('transaction_date')->first();
                if ($last_trans !== null) {
                    $transaction->pin_beginning_balance = $last_trans->pin_ending_balance;
                    $transaction->pin_ending_balance = $last_trans->pin_ending_balance;
                }*/
            }

            $bonus = $faktor_kali * $nilai_point;
            $transaction->bonus_partner_amount = $transaction->bonus_partner_amount + $bonus;
            $level = $upline->level_id === null ? 'NULL' : ($upline->level_id === 1 ? 'BRONZE' : 'GOLD');

            $transaction->remarks = $this->createRemarks($transaction,
                'Bonus pasangan antara ( [ ' . $new_member->code . ' - ' . $new_member->name . ' ] dengan [ ' . $pair->code . ' - ' . $pair->name . ' ] ):  Level: ' . $level .
                ', [ (' . number_format($faktor_kali, 0) . ') * ' .
                number_format($nilai_point, 0) . ') ] = ' .
                number_format($bonus, 0)
            );

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

        $m_level = $upline->level_id; //$new_member->level_id;
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

    private function createRemarks($transaction, $message)
    {
        $remarks = '';
        if ($transaction->remarks === null)
            $remarks = $message;
        else
            $remarks = $transaction->remarks . PHP_EOL . $message;
        return $remarks;
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

    public function processMemberLevel()
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
                    'status_id' => 3,
                    'remarks' => 'Batas TUPO terlewati'
                ]);
            }
        }

    }

}
