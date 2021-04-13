<?php


namespace App\Http\Controllers\Members;


use App\Http\Controllers\Controller;
use App\Level;
use App\Member;
use App\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MemberController extends Controller
{
    public function getMember($id)
    {
        $member = Member::find($id);

        $ids = $member->toArray();
        $ids['left_downline'] = json_encode(new \stdClass());
        $ids['right_downline'] = json_encode(new \stdClass());

        if ($member->left_downline_id)
            $ids['left_downline'] = json_encode($member->leftDownLine);

        if ($member->right_downline_id)
            $ids['right_downline'] = json_encode($member->rightDownLine);

        return json_encode($ids);
    }

    public function getMemberNew(Request $request)
    {
        $member = Member::find($request->id);

        $ids = $member->toArray();
        $ids['left_downline'] = json_encode(new \stdClass());
        $ids['right_downline'] = json_encode(new \stdClass());

        if ($member->left_downline_id)
            $ids['left_downline'] = json_encode($member->leftDownLine);

        if ($member->right_downline_id)
            $ids['right_downline'] = json_encode($member->rightDownLine);

        return json_encode($ids);
    }

    public function getPoint($id)
    {
        $levels = Level::all();
        $member = Member::find($id);

        return json_encode([ 'member' => $member->toArray(), 'levels' => $levels->toArray() ]);
    }

    public function transferPin(Request $request) {
        $valid = $this->validate($request, [
            '_acc_' => 'required',
            'member_id' => 'required',
            'amount' => 'required'
        ]);

        $id = $request->_acc_; //auth()->id();

        $user = Member::find($id);
        $member = Member::find($request->member_id);

        $allMembers = Member::all();

        $user_pin = intval($user->pin);
        $member_pin = intval($member->pin);

        $message_get = '[' . $member->code . ' - ' . $member->name . '] menerima PIN dari member [ ' . $user->code . ' - ' . $user->name . ' ]';

        // Di sisi member yang di transfer
        Transaction::create([
            'member_id' => $request->member_id,
            'user_id' => $id,
            'status_id' => 3,   //Processed
            'type' => 'pin',
            'trans' => 'RCV-POINT',
            'pin_beginning_balance' => $member_pin,
            'pin_amount' => intval($request->amount),
            'pin_ending_balance' => ($member_pin + $request->amount),
            'remarks' => $message_get
        ]);

        $message_trf = '[' . $user->code . ' - ' . $user->name . '] mengirim PIN kepada member [ ' . $member->code . ' - ' . $member->name . ' ]';

        // Di sisi member yang mentransfer
        Transaction::create([
            'member_id' => $id,
            'user_id' => $request->member_id,
            'status_id' => 3,   //Processed
            'type' => 'pin',
            'trans' => 'TRF-POINT',
            'pin_beginning_balance' => $user_pin,
            'pin_amount' => 0 - intval($request->amount),
            'pin_ending_balance' => ($user_pin - $request->amount),
            'remarks' => $message_trf
        ]);

        $user->pin = $user_pin - intval($request->amount);
        $member->pin = $member_pin + intval($request->amount);

        $user->save();
        $member->save();

        return json_encode(['status' => true, 'message' => 'Transfer PIN berhasil.']);

        /*return view('members/transfer-pin', [
            'member' => $member,
            'allMembers' => $allMembers
        ]);*/
    }

    public function getStockiest()
    {
        $members = Member::where('is_stockiest', '=', '1')-get();

        return json_encode($members);
    }

    public function getBonusHistory(Request $request)
    {
        $valid = $this->validate($request, [
            '_acc_' => 'required',
            'start_date' => 'required',
            'end_date' => 'required'
        ]);

        $id = $request->_acc_;
        $member = Member::find($id);

        $arr = [];
        $query = DB::select();
        foreach ($query as $item) {
            array_push($arr, $item);
        }

        return json_encode($arr);
    }

    public function validateKTP($nik)
    {
        $count = Member::where('nik', '=', $nik)->count();
        return json_encode([ 'status' => $count < 3 ]);
    }

}
