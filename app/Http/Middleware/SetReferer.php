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
        if (strpos(URL::previous(), $_SERVER['HTTP_HOST']))
        {
        //   Log::info('Setting redirect to - ' . URL::previous());
        //   Session::set('redirect', URL::previous());
        }
        else
        {
          Log::info('Referer is external - ' . $_SERVER['HTTP_HOST'] . ' - ' . URL::previous());
        }
  		}

      return $next($request);
    }
}
