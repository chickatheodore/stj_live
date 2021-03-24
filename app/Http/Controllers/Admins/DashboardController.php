<?php

namespace App\Http\Controllers\Admins;

use App\Member;
use App\TransactionPoint;
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

    public function expiredPoint()
    {
        $expired = Member::where('close_point_date', '<', Carbon::now()->format('Y-m-d'))->get();

        return view('/admins/expired', [
            'expired' => $expired
        ]);
    }

    public function pointHistory()
    {
        $members = Member::all();

        return view('/admins/history', [
            'members' => $members
        ]);
    }


    /*
     * AJAX call
     */

    public function getPointHistory(Request $request)
    {
        $transactions = TransactionPoint::where('member_id', '=', $request->id);

        if (isset($request->from_date))
            $transactions = $transactions->whereBetween('transaction_date', [$request->start_date,$request->end_date]);

        $result = $transactions->get();

        return json_encode($result);
    }
}

