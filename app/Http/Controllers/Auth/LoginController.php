<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Member;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

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
        $this->clearToken();

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
        if ($token = $this->guardLogin($request, Config::get('constants.guards.admin'))) {
            $this->setToken($request);
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

        /*$pass = Hash::make($request->password);
        $_pass = Hash::make($request->password, [ 'rounds' => 10 ]);

        $pass0 = bcrypt($request->password);
        $pass1 = password_hash ($request->password, PASSWORD_DEFAULT);
        $pass2 = password_hash ($request->password, PASSWORD_BCRYPT);

        $cocok = password_hash('123456',PASSWORD_DEFAULT, [ 'cost' => 10 ]);
        $pass3 = password_hash ($request->password, PASSWORD_ARGON2I);
        $pass4 = password_hash ($request->password, PASSWORD_ARGON2ID);*/

        if ($token = $this->guardLogin($request, $mem)) {
            $this->setToken($request);
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

        $member = Member::where($this->username(), '=', $request->username)->first();
        if ($member !== null)
        {
            $active = $member->is_active;
            if ($active === 0)
                return false;
        }

        return Auth::guard($guard)->attempt(
          $req,
          $request->get('remember')
        );
    }

    private function setToken(Request $request)
    {

        $random = Str::random(60);
        $token = \hash('sha256', $random);

        //$user = Auth::user();
        //$accessToken = $this->guard()->user()->createToken('authToken')->accessToken;   //auth()->user()->createToken('authToken')->accessToken;

        $_COOKIE['stj_token'] = $token;  //setcookie('stj_token', $token);

        //Session::put('stj_token', $token);
        session(['stj_token' => $token]);
        $_SESSION['stj_token'] = $token;
        $request->session()->put('stj_token', $token);

        //setcookie('access_token', $accessToken);
        //Session::put('access_token', $accessToken);

        return $token;
    }

    private function clearToken()
    {
        if (isset($_COOKIE['stj_token']))
        {
            unset($_COOKIE['stj_token']);
            setcookie('stj_token', null, -1);
        }
        Session::forget([ 'stj_token' ]);

        /*if (isset($_COOKIE['access_token']))
        {
            unset($_COOKIE['access_token']);
            setcookie('access_token', null, -1);
        }
        Session::forget([ 'access_token' ]);*/
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
