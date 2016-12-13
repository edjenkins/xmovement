<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

use Auth;
use Config;
use DynamicConfig;
use Gate;
use Log;
use Lang;
use MetaTag;
use Response;
use Session;

use App\User;

class ResponseObject {

	public $meta = array();
	public $errors = array();
	public $data = array();

	public function __construct()
	{
		$this->meta['success'] = false;
	}
}

class AdminController extends Controller
{
    public function emailTest(Request $request)
    {
		$job = (new SendTestEmails())->onQueue('emails');//->delay(30)

		$this->dispatch($job);

		return 'Test emails sent!';
    }

	public function managePlatform()
	{
		# META
		MetaTag::set('title', Lang::get('meta.admin_title'));
		MetaTag::set('description', Lang::get('meta.admin_description'));
		# META

		if (Gate::denies('manage_platform', Auth::user()))
		{
			Session::flash('flash_message', trans('flash_message.no_permission'));
            Session::flash('flash_type', 'flash-danger');

			return redirect()->action('PageController@home');
		}
		else
		{
			return view('admin.management.index');
		}
    }

	public function updateConfig(Request $request)
	{
		$response = new ResponseObject();

		if (Gate::denies('platform_configuration', Auth::user()))
		{
            array_push($response->errors, trans('flash_message.no_permission'));
		}
		else
		{
			$response->meta['success'] = true;

			$response->data = DynamicConfig::updateConfig($request->key, $request->value, $request->type);
		}

		return Response::json($response);
	}

	public function fetchConfig(Request $request)
	{
		$response = new ResponseObject();

		if (Gate::denies('platform_configuration', Auth::user()))
		{
            array_push($response->errors, trans('flash_message.no_permission'));
		}
		else
		{
			$response->meta['success'] = true;

			$value = DynamicConfig::fetchConfig($request->key);

			$response->data = $value;
		}

		return Response::json($response);
	}

	public function updatePermissions(Request $request)
	{
		$response = new ResponseObject();

		// if (Gate::denies('platform_configuration', Auth::user()))
		// {
        //     array_push($response->errors, trans('flash_message.no_permission'));
		// }
		// else
		// {
			$response->meta['success'] = true;

			$user = User::where(['id' => $request->user_id])->first();

			Log::error($request->key);
			
			$user[$request->key] = $request->value;

			$user->save();

			$response->data = $user;
		// }

		return Response::json($response);
	}

	public function fetchPermissions(Request $request)
	{
		$response = new ResponseObject();

		// if (Gate::denies('platform_configuration', Auth::user()))
		// {
        //     array_push($response->errors, trans('flash_message.no_permission'));
		// }
		// else
		// {
			$response->meta['success'] = true;

			// $value = DynamicPermissions::fetchPermissions($request->key);

			$response->data = User::where(['id' => $request->user_id])->first();
		// }

		return Response::json($response);
	}

}
