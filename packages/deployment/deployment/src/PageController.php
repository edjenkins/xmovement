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

use Lang;
use MetaTag;

class PageController extends Controller
{
    public function competition(Request $request)
	{
		# META
		MetaTag::set('title', Lang::get('meta.competition_title'));
		MetaTag::set('description', Lang::get('meta.competition_description'));
		# META

	    return view('deployment.pages.competition');
	}

}
