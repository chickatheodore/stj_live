<?php

namespace App\Http\Controllers\Members;

use App\Member;
use App\MemberCount;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    // Dashboard - Analytics
    public function dashboardAnalytics(){
        $pageConfigs = [
            'pageHeader' => false
        ];

        $id = auth()->id();
        $member = Member::find($id);

        $child = [ 'left_count' => 0, 'right_count' => 0 ];
        if ($member->left_downline_id !== null)
        {
            $left = MemberCount::where('id', '=', $member->left_downline_id)->get();
            if ($left != null) {
                $child['left_count'] = $left[0]->child_count;
            }
        }
        if ($member->right_downline_id !== null)
        {
            $right = MemberCount::where('id', '=', $member->right_downline_id)->get();
            if ($right != null) {
                $child['right_count'] = $right[0]->child_count;
            }
        }

        return view('/members/dashboard', [
            'pageConfigs' => $pageConfigs,
            'member' => $member,
            'child' => $child
        ]);
    }
}

