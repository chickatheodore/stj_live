<?php

namespace App\Http\Controllers\Admins;

use App\Member;
use App\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index(){
        $pageConfigs = [
            'pageHeader' => false
        ];

        return view('/admins/dashboard', [
            'pageConfigs' => $pageConfigs
        ]);
    }

    public function expiredTUPO()
    {
        return view('/admins/expired', [
            //'expired' => $expired
        ]);
    }

    public function pointHistory()
    {
        //$members = Member::all();

        return view('/admins/point-history', [
            //'members' => $members
        ]);
    }


    /*
     * AJAX call
     */

    public function getPointHistory(Request $request)
    {
        $start = Carbon::parse($request->start_date)->format('Y-m-d') . ' 00:00:00';
        $end = Carbon::parse($request->end_date)->format('Y-m-d') . ' 23:59:59';

        $transactions = Transaction::with('member')
            ->whereBetween('transaction_date', [$start, $end])
            ->orderBy('transaction_date');

        $trans = [];
        $result = $transactions->get();
        foreach ($result as $transaction)
        {
            $arr = $transaction->toArray();
            $arr['transaction_date'] = Carbon::parse($transaction->transaction_date)->format('d-M-Y');
            $arr['member_name'] = $transaction->member->code . ' - ' . $transaction->member->name;
            array_push($trans, $arr);
        }

        return json_encode($trans);
    }
}

