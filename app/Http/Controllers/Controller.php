<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

  public function getGuard()
  {
    if(Auth::guard('admin')->check())
    {
      return "admin";
    }
    elseif(Auth::guard('member')->check())
    {
      return "member";
    }
    elseif(Auth::guard('web')->check())
    {
      return "web";
    }
    return "";
  }
}
