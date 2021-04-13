<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class TimeBasedRestriction
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //stop akses sesuai dengan jam yang telah ditentukan
        if (now()->isBetween('00:00:01', '06:00:00') && env('APP_DEBUG', false) === false) {
            return response()->view('maintenance', [], 403);
        }
        return $next($request);
    }
}
