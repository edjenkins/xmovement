<?php

namespace App\Http\Middleware;

use Closure;

use Session;

class CheckCreationPhase
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
		if (!DynamicConfig::fetchConfig('CREATION_MODE_ENABLED', true))
		{
			// Creation phase disabled
			Session::flash('flash_message', trans('flash_message.page_not_found'));
            Session::flash('flash_type', 'flash-danger');

			return redirect()->action('PageController@home');
		}

        return $next($request);
    }
}
