<?php


namespace App\Http\Controllers;

use App\Jobs\ProcessMember;
use Illuminate\Http\Request;


class BonusController extends Controller
{
    public function processBonus()  /*Request $request*/
    {
        dispatch(new ProcessMember(null, null));
    }
}
