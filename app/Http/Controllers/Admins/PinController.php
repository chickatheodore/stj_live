<?php

namespace App\Http\Controllers\Admins;

use App\Member;
use App\TransactionPoint;
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
        $member->pin = $member->pin + intval($request->amount);
        $member->save();

        $amount = intval($request->amount) + intval($member->pin);

        TransactionPoint::create([
            'member_id' => $member->id,
            'user_id' => 1,
            'status_id' => 3,
            'trans' => 'ADMIN-TRF',
            'amount' => $request->amount,
            'beginning_balance' => $member->pin,
            'income' => $request->amount,
            'ending_balance' => $amount
        ]);

        return json_encode(['status' => true]);
    }

}

