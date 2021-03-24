<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('guest:admin')->except('logout');
        $this->middleware('guest:member')->except('logout');
    }

    // Login
    public function showLoginForm(){
      $pageConfigs = [
          'bodyClass' => "bg-full-screen-image",
          'blankPage' => true
      ];

      return view('/auth/login', [
          'pageConfigs' => $pageConfigs
      ]);
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $guard = $this->getGuard();

        $this->guard()->logout();

        $request->session()->invalidate();

        if ($guard == 'admin' || $guard == 'member')
          return $this->loggedOut($request) ?: redirect('/' . $guard . '/login');
        else
          return $this->loggedOut($request) ?: redirect('/member/login');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showAdminLoginForm()
    {
        $pageConfigs = [
            'bodyClass' => "bg-full-screen-image",
            'blankPage' => true
        ];

        return view('auth.admin', [
            'pageConfigs' => $pageConfigs,
            'url' => Config::get('constants.guards.admin')
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showMemberLoginForm()
    {
        $pageConfigs = [
            'bodyClass' => "bg-full-screen-image",
            'blankPage' => true
        ];

        return view('auth.login', [
            'pageConfigs' => $pageConfigs,
            'url' => Config::get('constants.guards.member')
        ]);
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function adminLogin(Request $request)
    {
        if ($this->guardLogin($request, Config::get('constants.guards.admin'))) {
            return redirect()->intended('/admin/home');
        }

        return back()->withInput($request->only('username', 'remember'));
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function memberLogin(Request $request)
    {
        $mem = Config::get('constants.guards.member');

        //$hash = password_hash($request->password,)
        $hash_make = Hash::make($request->password);

        if ($this->guardLogin($request, $mem)) {
            return redirect()->intended('/member/home');
        }

        return back()->withInput($request->only('username', 'remember'));
    }


    /**
     * @param Request $request
     * @return array
     */
    protected function validator(Request $request)
    {
        return $this->validate($request, [
            'username'   => 'required',
            'password' => 'required|min:6'
        ]);
    }

    /**
     * @param Request $request
     * @param $guard
     * @return bool
     */
    protected function guardLogin(Request $request, $guard)
    {
        $this->validator($request);

        $req = [
            //'username' => $request->username,
            $this->username() => $request->username,
            'password' => $request->password
        ];

        return Auth::guard($guard)->attempt(
          $req,
          $request->get('remember')
        );
    }

    public function username()
    {
        $login = request()->input('username');
        if(is_numeric($login)){
            $field = 'code';
        } elseif (filter_var($login, FILTER_VALIDATE_EMAIL)) {
            $field = 'email';
        } else {
            $field = 'username';
        }
        request()->merge([$field => $login]);
        return $field;
    }

}
