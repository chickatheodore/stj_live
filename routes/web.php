<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LanguageController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


// Route url
Route::group(['middleware' => 'restrictMidnight'], function () {
    Route::get('/', 'DashboardController@dashboardSPA')->name('home');

    Route::get('/admin/images/logo/favicon.ico', function () {
        return \File::get(public_path() . '/images/logo/favicon.ico');
    });
    Route::get('/member/images/logo/favicon.ico', function () {
        return \File::get(public_path() . '/images/logo/favicon.ico');
    });

    Auth::routes();

    Route::get('/admin/login', 'Auth\LoginController@showAdminLoginForm');
    Route::post('/admin/login', 'Auth\LoginController@adminLogin');
    Route::get('/admin/logout', 'Auth\LoginController@logout');

    Route::get('/member/login', 'Auth\LoginController@showMemberLoginForm');
    Route::post('/member/login', 'Auth\LoginController@memberLogin');
    Route::get('/member/logout', 'Auth\LoginController@logout');

    Route::get('/member/rebuildAllTrees', 'Members\TreeController@rebuildTree');
});

Route::group(['prefix' => 'admin', 'middleware' => ['auth:admin', 'restrictMidnight']], function() {
    Route::get('/', 'Admins\DashboardController@index');
    Route::get('home', 'Admins\DashboardController@index');

    //Route::resources(['member' => 'Admins\MemberSettingController']);
    Route::get('member', 'Admins\MemberSettingController@index');
    Route::get('member/create', 'Admins\MemberSettingController@create');
    Route::get('member/edit/{id}', 'Admins\MemberSettingController@edit');
    Route::post('member/save', 'Admins\MemberSettingController@store')->name('member.save');

    Route::get('trf-pin', 'Admins\PinController@showTransferPINForm');
    Route::post('trf-pin', 'Admins\PinController@transferPIN');

    Route::get('paid-bonus', 'Admins\AdminController@showPaidBonusForm');
    Route::get('unpaid-bonus', 'Admins\AdminController@showUnpaidBonusForm');
    Route::post('payBonus', 'Admins\AdminController@payBonus');

    Route::get('expired', 'Admins\DashboardController@expiredTUPO');
    Route::get('point-history', 'Admins\DashboardController@pointHistory');
});

Route::group(['prefix' => 'member', 'middleware' => ['auth:member', 'restrictMidnight']], function() {
    Route::get('/register', 'Members\PagesController@showMemberRegistrationForm');
    Route::post('/register', 'Members\PagesController@createMember')->name('member.registration');

    Route::get('placement', 'Members\PagesController@showMemberPlacementForm');
    Route::post('placement', 'Members\PagesController@memberPlacement')->name('member.placement');

    Route::get('/', 'Members\DashboardController@dashboardAnalytics');
    Route::get('/home', 'Members\DashboardController@dashboardAnalytics');

    Route::get('profile', 'Members\PagesController@userProfile');

    Route::get('tree', 'Members\TreeController@getTree');
    Route::get('sponsor', 'Members\PagesController@sponsor');

    Route::get('bonus', 'Members\PagesController@getBonus');
    Route::get('bonus-history', 'Members\PagesController@showBonusHistory');

    Route::get('pin', 'Members\PagesController@showPin');
    Route::get('transfer-pin', 'Members\PagesController@showTransferPin');

    Route::get('extend', 'Members\PagesController@showExtendTUPO');
    Route::get('upgrade', 'Members\PagesController@showUpgradeLevel');

    Route::get('point-history', 'Members\PagesController@showPINHistory');
    Route::get('stockiest', 'Members\PagesController@stockiest');
});

Route::group(['middleware' => ['nodebugbar', 'restrictMidnight']], function () {
    Route::get('/admin/getMembers', 'Admins\MemberSettingController@getMembers');
    Route::get('/admin/unpaidBonus', 'Admins\AdminController@unpaidBonus');
    Route::get('/admin/paidBonus', 'Admins\AdminController@paidBonus');
    Route::get('/admin/expiredTUPO', 'Admins\AdminController@expiredTUPO');
});

/*Route::group(['middleware' => ['stj_api', 'restrictMidnight', 'nodebugbar']], function () {
    Route::get('/member/getMember', 'Members\MemberController@getMemberNew');
});*/

Route::group(['middleware' => ['stj_ajax', 'restrictMidnight', 'nodebugbar']], function () {

    Route::get('/admin/getPointHistory', 'Admins\DashboardController@getPointHistory');
    Route::post('/admin/transferPIN', 'Admins\PinController@transferPIN');

    //Route::get('/admin/tupoExpired', 'Admins\DashboardController@expiredPoint');

    //Route::get('/admin/getMembers', 'Admins\MemberSettingController@getMembers');
    Route::get('/member/getMember/{id}', 'Members\MemberController@getMember');
    Route::get('/member/getPoint/{id}', 'Members\MemberController@getPoint');
    Route::post('/member/getMemberTree', 'Members\TreeController@getMemberTree');
    Route::post('/member/getMemberTree/{id}', 'Members\TreeController@getMemberTree');
    Route::get('/member/getStockiest', 'Members\MemberController@getStockiest');

    Route::post('/member/getBonusHistory', 'Members\PagesController@getBonusHistory');
    Route::post('/member/getPINHistory', 'Members\PagesController@getPINHistory');

    Route::post('/member/transferPin', 'Members\MemberController@transferPin');
    Route::post('/member/upgradeLevel', 'Members\PagesController@upgradeLevel')->name('member.profile.upgrade');
    Route::post('/member/extend', 'Members\PagesController@extendTUPO');

    Route::post('/member/profileGeneral', 'Members\PagesController@updateProfileGeneral')->name('member.profile.general');
    Route::post('/member/profileAccount', 'Members\PagesController@updateProfileAccount')->name('member.profile.account');
    Route::post('/member/profileInfo', 'Members\PagesController@updateProfileInfo')->name('member.profile.info');

});

Route::get('/clear-cache', function() {
    Artisan::call('cache:clear');
    return "Cache is cleared";
});

Route::group(['prefix' => 'system'], function() {
    Route::get('/processBonus', function() {
        Artisan::call('cache:clear');
    });
});
