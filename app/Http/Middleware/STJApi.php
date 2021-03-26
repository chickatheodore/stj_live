<?php


namespace App\Http\Middleware;


use Closure;
use Illuminate\Http\Request;

class STJApi
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //$has = session()->has('stj_token');
        $token = $request->bearerToken();

        if ($token && $request->ajax())
        {
            //$cookie = $_COOKIE['XSRF-TOKEN'];
            //if ($token == $cookie)
                return $next($request);
        }

        abort(403, 'Unauthorized Access!');
    }
}
