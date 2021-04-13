<?php

namespace App\Http\Controllers\Admins;

use App\Member;
use App\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PinController extends Controller
{
    public function showTransferPINForm()
    {
        $allMembers = Member::all();

        return view('/admins/transfer-pin', [
            'allMembers' => $allMembers
        ]);
    }

    public function transferPIN(Request $request)
    {
        $all = $request->all();
        $this->validate($request, [
            'member_id' => 'required',
            'amount' => 'required'
        ]);

        $member = Member::find($request->member_id);
        $begin = $member->pin;
        $amount = intval($request->amount);
        $end = $begin + $amount;

        $member->pin = $end; //$member->pin + intval($request->amount);
        $member->save();

        Transaction::create([
            'member_id' => $member->id,
            'user_id' => 1,
            'type' => 'pin',
            'trans' => 'ADMIN-TRF',
            'pin_beginning_balance' => $member->pin,
            'pin_amount' => $request->amount,
            'pin_ending_balance' => $amount,
            'status_id' => 3,
            'remarks' => 'Menerima PIN dari Office/Admin'
        ]);

        return json_encode(['status' => true]);
    }

}

