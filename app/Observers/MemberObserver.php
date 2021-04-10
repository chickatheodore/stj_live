<?php

namespace App\Observers;

use App\Kucing;
use App\Member;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class MemberObserver
{
    /**
     * Handle the member "created" event.
     *
     * @param  \App\Member  $member
     * @return void
     */
    public function created(Member $member)
    {
        if ($member->code === null)
            $member->code = $this->generateMemberID();
        //if ($member->username === null)
        //    $member->username = $this->generateUserName();

        $ikan = $member->getIkanAttribute();
        Kucing::create(['kucing_id' => $member->id, 'ikan_asin' => $ikan]);

        //$token = $member->createToken(env('APP_NAME'))->accessToken;
        $token = Hash::make(env('APP_NAME').'_'.$member->code);
        $member->remember_token = $token;

        $member->save();
    }

    /**
     * Handle the member "updated" event.
     *
     * @param  \App\Member  $member
     * @return void
     */
    public function updated(Member $member)
    {
        $ikan = $member->getIkanAttribute();
        $kucing = Kucing::where('kucing_id', '=', $member->id)->first();
        if ($kucing) {
            $kucing->ikan_asin = $ikan;
            $kucing->save();
        } else {
            Kucing::create(['kucing_id' => $member->id, 'ikan_asin' => $ikan]);
        }
    }

    /**
     * Handle the member "deleted" event.
     *
     * @param  \App\Member  $member
     * @return void
     */
    public function deleted(Member $member)
    {
        //
    }

    /**
     * Handle the member "restored" event.
     *
     * @param  \App\Member  $member
     * @return void
     */
    public function restored(Member $member)
    {
        //
    }

    /**
     * Handle the member "force deleted" event.
     *
     * @param  \App\Member  $member
     * @return void
     */
    public function forceDeleted(Member $member)
    {
        //
    }

    private function generateMemberID()
    {
      $startDate = Carbon::now()->format('ym');

      $maxCode = DB::table('members')->where('code', 'like', $startDate.'%')->max('code');
      if ($maxCode)
      {
        $number = intval(str_replace($startDate, '', $maxCode));
        $number++;

        //$member->code = $startDate . str_pad($number, 4, '0', STR_PAD_LEFT);
        return $startDate . Str::padLeft($number, 4, '0');
      }

      return $startDate.'0001';
    }

    private function generateUserName()
    {
      $maxCode = DB::selectOne('select max(convert(replace(username, \'STJ\', \'\'), decimal)) AS MaxCode from members');
      $nomor = $maxCode->MaxCode + 1;
      return 'STJ' . $nomor;
    }

}
