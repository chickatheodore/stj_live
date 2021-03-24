<?php


namespace App\Http\Middleware;


use Closure;
use DebugBar\DebugBar;

class NoDebugBar
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            //Debugbar::disable();
            app('debugbar')->disable();
        } catch (\Exception $e) {
            $aa = '';
        }
        return $next($request);
    }
}
