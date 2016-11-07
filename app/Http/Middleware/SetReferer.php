<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use URL;

class SetReferer
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
		if (!((strpos(URL::previous(), 'login') || strpos(URL::previous(), 'register') || strpos(URL::previous(), 'auth'))))
		{
			Session::set('redirect', URL::previous());
		}

        return $next($request);
    }
}
