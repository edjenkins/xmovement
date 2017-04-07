<?php

namespace App\Http\Middleware;

use Closure;
use Lang;
use Log;
use Session;
use URL;
use MetaTag;

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
		# DEFAULT META
		MetaTag::set('title', Lang::get('meta.default_title'));
		MetaTag::set('description', Lang::get('meta.default_description'));
		MetaTag::set('image', env('APP_SITE_IMAGE'));
		# DEFAULT META

		if (!((strpos(URL::previous(), 'login') || strpos(URL::previous(), 'register') || strpos(URL::previous(), 'auth'))))
		{
			// Session::set('redirect', URL::previous());
		}

        return $next($request);
    }
}
