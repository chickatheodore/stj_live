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

}
