<?php


namespace App\Http\Controllers\API;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Member;

class MemberController extends Controller
{
    public function getMember(Request $request)
    {
        $member = Member::find($request->id);

        $ids = $member->toArray();
        $ids['left_downline'] = json_encode(new \stdClass());
        $ids['right_downline'] = json_encode(new \stdClass());

        if ($member->left_downline_id)
            $ids['left_downline'] = json_encode($member->leftDownLine());

        if ($member->right_downline_id)
            $ids['right_downline'] = json_encode($member->rightDownLine());

        return response()->json($ids);
    }
}
