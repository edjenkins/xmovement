<?php

namespace Deployment\Deployment;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Auth;
use DB;
use Gate;
use Response;
use Input;
use Log;
use Session;
use View;

class PageController extends Controller
{
    public function competition(Request $request)
	{
	    return view('deployment.pages.competition');
	}

}
