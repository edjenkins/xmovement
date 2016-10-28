<?php

namespace App\Http\Middleware;

use Closure;

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

				if (!env('INSPIRATION_PHASE_ENABLED', false))
				{
					// Creation phase disabled
					Session::flash('flash_message', trans('flash_message.page_not_found'));
					Session::flash('flash_type', 'flash-danger');

					return redirect()->action('PageController@home');
				}

				break;

			case 'creation':

				if (!env('CREATION_PHASE_ENABLED', true))
				{
					// Creation phase disabled
					Session::flash('flash_message', trans('flash_message.page_not_found'));
					Session::flash('flash_type', 'flash-danger');

					return redirect()->action('PageController@home');
				}

				break;

			case 'tender':

				if (!env('TENDER_PHASE_ENABLED', false))
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
