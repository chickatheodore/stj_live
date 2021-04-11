<?php


namespace App\Http\Controllers\Admins;


use App\City;
use App\Country;
use App\Http\Controllers\Controller;
use App\Kucing;
use App\Member;
use App\Province;
use App\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function showUnpaidBonusForm()
    {
        $breadcrumbs = [
            ['link'=>"/admin/home",'name'=>"Home"], ['name'=>"List Bonus belum dibayar"]
        ];
        return view('/admins/bonus-unpaid', [
            'breadcrumbs' => $breadcrumbs
        ]);
    }

    public function unpaidBonus()
    {
        $transactions = Transaction::with('member')->where(function ($query){ return $query->where('type', '=', 'all')->orWhere('type', '=', 'point');})
            ->where('status_id', '<', '3')->where('bonus_ending_balance', '>', '0')->get();

        $items = [];
        foreach ($transactions as $transaction) {
            array_push($items, [
                'id' => $transaction->id,
                'Tanggal' => Carbon::parse($transaction->transaction_date)->format('d-M-Y'),
                'MemberID' => $transaction->member->code,
                'Name' => $transaction->member->name,
                'BonusPoint' => floatval($transaction->bonus_point_amount),
                'BonusSponsor' => floatval($transaction->bonus_sponsor_amount),
                'Total' => $transaction->bonus_point_amount + $transaction->bonus_sponsor_amount
            ]);
        }

        return json_encode($items);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function showPaidBonusForm()
    {
        $breadcrumbs = [
            ['link'=>"/admin/home",'name'=>"Home"], ['name'=>"List Bonus sudah dibayar"]
        ];
        return view('/admins/bonus-paid', [
            'breadcrumbs' => $breadcrumbs
        ]);
    }

    public function paidBonus()
    {
        $transactions = Transaction::with('member')->where(function ($query){ return $query->where('type', '=', 'all')->orWhere('type', '=', 'point');})
            ->where('status_id', '=', '3')->get();

        $items = [];
        foreach ($transactions as $transaction) {
            array_push($items, [
                'id' => $transaction->id,
                'Tanggal' => Carbon::parse($transaction->transaction_date)->format('d-M-Y'),
                'MemberID' => $transaction->member->code,
                'Name' => $transaction->member->name,
                'BonusPoint' => floatval($transaction->bonus_point_amount),
                'BonusSponsor' => floatval($transaction->bonus_sponsor_amount),
                'Total' => $transaction->bonus_point_amount + $transaction->bonus_sponsor_amount
            ]);
        }

        return json_encode($items);
    }

    public function expiredTUPO()
    {
        $expired = Member::where('close_point_date', '<', Carbon::now()->format('Y-m-d'))
            ->orderBy('close_point_date')->get();

        return json_encode($expired);
    }

    public function payBonus(Request $request)
    {
        //$arr = explode(',', $request->ids);
        //DB::statement('update transactions set status_id = 3, bonus_paid_amount = bonus_point_amount
        //    where id in (:my_id)', array('my_id', $request->ids));

        $datas = json_decode($request->rows);
        foreach ($datas as $data) {
            $transaction = Transaction::find($data);
            $member = Member::find($transaction->member_id);

            $amount = $transaction->bonus_point_amount + $transaction->bonus_sponsor_amount + $transaction->bonus_partner_amount;
            $member_amount = $member->point_bonus + $member->sponsor_bonus  + $member->pair_bonus;

            //Set status transaksi = 3
            $transaction->status_id = 3;
            $transaction->save();

            //Simpan perubahan nilai bonus di table Member
            $member->point_bonus = $member->point_bonus - $transaction->bonus_point_amount;
            $member->sponsor_bonus = $member->sponsor_bonus - $transaction->bonus_sponsor_amount;
            $member->pair_bonus = $member->pair_bonus - $transaction->bonus_partner_amount;
            try {
                $member->save();
            } catch (\Exception $e)
            {
                $a = $e->getMessage();
            }

            //Buat transaksi baru untuk proses pembayarannya
            try {
                Transaction::create([
                    'member_id' => $member->id,
                    'user_id' => 1,
                    'type' => 'point',
                    'trans' => 'PAYMENT',
                    'bonus_beginning_balance' => $member_amount,
                    'bonus_paid_amount' => $amount,
                    'bonus_ending_balance' => $member_amount - $amount,
                    'status_id' => 3,
                    'reff_id' => $transaction->id
                ]);
            } catch (\Exception $e)
            {
                $a = $e->getMessage();
            }

        }

        /*$member = Member::find($request->MemberID);

        $begin_balance = $member->point_bonus + $member->sponsor_bonus + $member->pair_bonus;

        $amount = 0;
        $end_balance = $begin_balance;
        $trans = Transaction::find($request->id);
        if ($trans)
        {
            $trans->status_id = 3;
            $trans->save();

            $amount = $trans->bonus_point_amount + $trans->bonus_sponsor_amount + $trans->bonus_partner_amount;
            $end_balance = $begin_balance - $amount;
        }

        Transaction::create([
            'member_id' => $request->MemberID,
            'user_id' => 1,
            'type' => 'point',
            'trans' => 'PAYMENT',
            'bonus_beginning_balance' => $begin_balance,
            'bonus_paid_amount' => $amount,
            'bonus_ending_balance' => $end_balance,
            'status_id' => 3,
            'reff_id' => $trans->id
        ]);

        $member->point_bonus = 0;
        $member->sponsor_bonus = 0;
        $member->pair_bonus = 0;
        $member->save();*/

        return json_encode([ 'success' => true ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function showUnapprovedMember()
    {
        $breadcrumbs = [
            ['link'=>"/admin/home",'name'=>"Home"], ['name'=>"Member belum di approve"]
        ];
        return view('/admins/member-unapproved', [
            'breadcrumbs' => $breadcrumbs
        ]);
    }

    public function unApproved()
    {
        $members = Member::where('is_active', '=', '0')->get();

        return json_encode($members);
    }

    public function approveMember(Request $request)
    {
        $now = Carbon::now();
        $tgl = Carbon::create($now->year, $now->month, 1, 0, 0, 0);
        $tgl = $tgl->addMonth(2)->subDay();

        $datas = json_decode($request->rows);

        foreach ($datas as $data) {
            $member = Member::find($data);

            $member->is_active = 1;
            $member->activation_date = Carbon::now();
            $member->close_point_date = $tgl;
            $member->remember_token = null;

            $member->save();
        }

        return json_encode([ 'success' => true ]);
    }

}
