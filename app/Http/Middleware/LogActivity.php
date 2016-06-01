<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\ActivityLog;
use URL;

class LogActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
		return $next($request);
	}

    public function terminate($request, $response)
	{
		$data = $request->all();

		if (in_array($request->path(), ['login', 'register']) || (substr($request->path(), 0, 14) === 'password/reset')) {
			// May contain password
			if (array_key_exists('password', $data)) {
				$data['password'] = 'sensitive';
			}
			if (array_key_exists('password_confirmation', $data)) {
				$data['password_confirmation'] = 'sensitive';
			}
		}

		ActivityLog::create([
			'request' => $request,
			'response' => $response,
			'data' => json_encode($data),
			'method' => $request->method(),
			'path' => $request->path(),
			'url' => $request->url(),
			'full_url' => $request->fullUrl(),
			'action' => $request->route()->getActionName(),
			'parameters' => json_encode($request->route()->parameters()),
			'ip' => $request->ip(),
			'referer' => URL::previous(),
			'user_agent' => $request->header('User-Agent'),
		]);
	}
}
