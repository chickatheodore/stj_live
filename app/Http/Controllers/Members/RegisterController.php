<?php

namespace App\Http\Controllers\Members;

use App\City;
use App\Country;
use App\Member;
use App\Province;
use App\User;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/member/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
        $this->middleware('guest:member');
        $this->middleware('auth:member');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            //'username' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    // Register
    public function showRegistrationForm() {
        $pageConfigs = [
            'bodyClass' => "bg-full-screen-image",
            'blankPage' => true
        ];

        return view('/auth/register', [
            'pageConfigs' => $pageConfigs
        ]);
    }

    // Register
    public function showMemberRegistrationForm() {
        if (!Auth::guard('member')->check()) {
            return redirect()->intended('/member/login');
        }

        $pageConfigs = [
            'bodyClass' => "bg-full-screen-image",
            'blankPage' => true
        ];

        $breadcrumbs = [
            [ 'link' => "home", 'name'=>"Home"], [ 'name' => 'Registrasi' ]
        ];

        //$allMembers = Member::all()->where('id', '>', 1);
        $countries = Country::all();
        $provinces = Province::all()->orderBy('name');
        $cities = City::all()->orderBy('province_id')->orderBy('name');

        return view('/members/register', [
            'breadcrumbs' => $breadcrumbs,
            //'pageConfigs' => $pageConfigs,
            //'allMembers' => $allMembers,
            'countries' => $countries,
            'provinces' => $provinces,
            'cities' => $cities
        ]);
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function createMember(Request $request)
    {
        $this->validator($request->all())->validate();
        //code, username

        $kiri = null;
        $kanan = null;
        $tempat = $request->pohonRadio;

        $now = Carbon::now();
        $tgl = Carbon::create($now->year, $now->month, 1, 0, 0, 0);
        $tgl = $tgl->addMonth(2)->subDay();

        $req = [
            'name' => $request->name,
            'nik' => $request->nik,
            'address' => $request->address,
            'city_id' => $request->city_id,
            'province_id' => $request->province_id,
            'postal_code' => $request->postal_code,
            'country_id' => $request->country_id,
            'phone' => $request->phone,
            'sponsor_id' => $request->sponsor_id,
            'upline_id' => $request->upline_id,
            'bank' => $request->bank,
            'account_number' => $request->account_number,
            'account_name' => $request->account_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_tupo' => '1',
            'is_active' => '1',     //Sementara bypass cek ktp
            'activation_date' => Carbon::now()->format('Y-m-d h:i:s'),
            'close_point_date' => $tgl->format('Y-m-d'),
            'ikan_asin' => $request->password
        ];

        $member = Member::create($req);
        //$member->setIkanAttribute($request->password);

        if ($tempat && $request->upline_id) {
            $upline = Member::find($request->upline_id);
            if ($tempat == 'left' && !$upline->left_downline_id) {
                $upline->left_downline_id = $member->id;
                $upline->save();
            }
            if ($tempat == 'right' && !$upline->right_downline_id) {
                $upline->right_downline_id = $member->id;
                $upline->save();
            }
        } else if ($request->upline_id) {
            $upline = Member::find($request->upline_id);
            $upline->left_downline_id = $member->id;
            $upline->save();
        }

        //return $member;
        return view('members/registered', [
            'member' => $member
        ]);
    }
}
