<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group([
  'prefix' => 'auth'
], function () {
  Route::post('login', 'AuthController@login');
  Route::post('register', 'AuthController@register');

  Route::group([
    'middleware' => 'auth:api'
  ], function() {
      Route::get('logout', 'AuthController@logout');
      Route::get('user', 'AuthController@user');
  });
});


Route::group([ 'middleware' => ['web', 'stj_api', 'restrictMidnight'] ], function() {
    Route::get('getMember', 'API\MemberController@getMember');

});

Route::group([ 'middleware' => ['auth:member_api', 'restrictMidnight'] ], function() {
    //Route::post('member/testAccount', 'Members\PagesController@updateProfileAccount')->name('member.profile.test');
    //Route::get('getMember', 'API\MemberController@getMember');

    //Route::post('member/profileGeneral', 'Members\PagesController@updateProfileGeneral')->name('member.profile.general');
    //Route::get('member/profileAccount', 'Members\PagesController@updateProfileAccount')->name('member.profile.account');
    //Route::post('member/profileInfo', 'Members\PagesController@updateProfileInfo')->name('member.profile.info');
});

