<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Gate;
use Response;
use Input;
use Log;
use Redirect;
use Session;

use App\Action;
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

class ActionController extends Controller
{
	public function log(Request $request)
	{
		$response = new ResponseObject();

		$response->meta['success'] = true;

		$authenticated_user_id = (Auth::user()) ? Auth::user()->id : null;

		$action = Action::create([
			'user_id' => $authenticated_user_id,
			'label' => $request->label,
			'url' => $request->url,
			'idea_id' => $request->idea_id,
			'data' => $request->data
		]);

		$response->data = $action;

		Log::error($response->data);

		return Response::json($response);
	}
}
