<?php

namespace App\Http\Controllers\Vuexy;

use App\Http\Controllers\Controller;
use App\Mirana\ContactUsEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class DashboardController extends Controller
{
    // Dashboard - Analytics
    public function dashboardAnalytics(){
        $pageConfigs = [
            'pageHeader' => false
        ];

        return view('/pages/dashboard-analytics', [
            'pageConfigs' => $pageConfigs
        ]);
    }

    // Dashboard - Ecommerce
    public function dashboardEcommerce(){
        $pageConfigs = [
            'pageHeader' => false
        ];

        return view('/pages/dashboard-ecommerce', [
            'pageConfigs' => $pageConfigs
        ]);
    }

    // Dashboard - SPA
    public function dashboardSPA() {
        return view('/home');
    }

    public function reloadCaptcha()
    {
        return response()->json(['captcha'=> captcha_img()]);
    }

    public function sendContactUsEmail(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required',
            'captcha' => 'required|captcha'
        ]);

        $all = $request->all();
        $to = 'made.mirana@gmail.com'; //env('MAIL_TO', 'admin@stjbali.com');
        try {
            Mail::to($to)->send(new ContactUsEmail($all));
        } catch (\Exception $e) {
            $a = $e->getMessage();
            return json_encode(['status' => false, 'message'=> 'Error while sending email.']);
        }

        return json_encode(['status' => true, 'message'=> 'Success']);
    }

}

