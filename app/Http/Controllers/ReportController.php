<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Report;

use Auth;
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

		$response->meta['success'] = true;

		Report::create([
			'user_id' => Auth::user()->id,
			'reportable_id' => $request->reportable_id,
			'reportable_type' => $request->reportable_type,
		]);

		return Response::json($response);
	}
}
