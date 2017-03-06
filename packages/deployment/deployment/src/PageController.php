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
use Lang;
use Log;
use MetaTag;
use Session;
use View;

class PageController extends Controller
{
	public function guidelines(Request $request)
	{
		# META
		MetaTag::set('title', Lang::get('meta.guidelines_title'));
		MetaTag::set('description', Lang::get('meta.guidelines_description'));
		# META

	    return view('deployment.pages.guidelines');
	}

	public function blog(Request $request)
	{
		# META
		MetaTag::set('title', Lang::get('meta.blog_title'));
		MetaTag::set('description', Lang::get('meta.blog_description'));
		# META

	    return view('deployment.pages.blog');
	}
}
