<?php

namespace App\Http\Controllers\Members;

use App\Member;
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

        return view('/members/dashboard', [
            'pageConfigs' => $pageConfigs,
            'member' => $member
        ]);
    }
}

