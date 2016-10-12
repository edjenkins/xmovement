<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Report;

use Auth;
use Lang;
use Response;

class ResponseObject {

	public $meta = array();
	public $errors = array();
	public $data = array();

	public function __construct()
	{
		$this->meta['success'] = false;
	}
}

class ReportController extends Controller
{
	public function add(Request $request)
	{
		$response = new ResponseObject();

		$report = Report::create([
			'user_id' => Auth::user()->id,
			'reportable_id' => $request->reportable_id,
			'reportable_type' => $request->reportable_type,
		]);

		if ($report)
		{
			$response->meta['success'] = true;
			$response->data['messages'] = [Lang::get('flash_message.content_reported')];
		}
		else
		{
			array_push($response->errors, Lang::get('flash_message.something_went_wrong'));
		}

		return Response::json($response);
	}
}
