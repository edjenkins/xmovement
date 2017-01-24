<?php

namespace App\Http\Middleware;

use Closure;

use DynamicConfig;
use Session;

class CheckPhase
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $phase)
    {
		switch ($phase) {

			case 'inspiration':

				if (!DynamicConfig::fetchConfig('INSPIRATION_MODE_ENABLED', false))
				{
					// Creation phase disabled
					Session::flash('flash_message', trans('flash_message.page_not_found'));
					Session::flash('flash_type', 'flash-danger');

					return redirect()->action('PageController@home');
				}

				break;

			case 'creation':

				if (!DynamicConfig::fetchConfig('CREATION_MODE_ENABLED', true))
				{
					// Creation phase disabled
					Session::flash('flash_message', trans('flash_message.page_not_found'));
					Session::flash('flash_type', 'flash-danger');

					return redirect()->action('PageController@home');
				}

				break;

			case 'tender':

				if (!DynamicConfig::fetchConfig('TENDER_MODE_ENABLED', false))
				{
					// Creation phase disabled
					Session::flash('flash_message', trans('flash_message.page_not_found'));
					Session::flash('flash_type', 'flash-danger');

					return redirect()->action('PageController@home');
				}

				break;

			default:

				break;
		}

        return $next($request);
    }
}
