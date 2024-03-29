<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use App\Idea;
use View;

use Cookie;
use Lang;
use MetaTag;

class PageController extends Controller
{
    public function home(Request $request)
	{
		# META
		MetaTag::set('title', Lang::get('meta.home_title'));
		MetaTag::set('description', Lang::get('meta.home_description'));
		# META

		if ($request->has('cookie_library_study'))
		{
			$request->session()->flash('cookie_library_study', 'no');
		}

	    $ideas = Idea::where('visibility','public')->take(3)->get();

		// Check if custom page set
		if (View::exists('deployment.pages.home')) { return view('deployment.pages.home', ['ideas' => $ideas]); }

	    return view('pages.home', ['ideas' => $ideas]);
	}

    public function about(Request $request)
	{
		# META
		MetaTag::set('title', Lang::get('meta.about_title'));
		MetaTag::set('description', Lang::get('meta.about_description'));
		# META

		// Check if custom page set
		if (View::exists('deployment.pages.about')) { return view('deployment.pages.about'); }

		return view('pages.about');
	}

    public function contact(Request $request)
	{
		# META
		MetaTag::set('title', Lang::get('meta.contact_title'));
		MetaTag::set('description', Lang::get('meta.contact_description'));
		# META

		// Check if custom page set
		if (View::exists('deployment.pages.contact')) { return view('deployment.pages.contact'); }

	    return view('pages.contact');
	}

    public function terms(Request $request)
	{
		# META
		MetaTag::set('title', Lang::get('meta.terms_title'));
		MetaTag::set('description', Lang::get('meta.terms_description'));
		# META

		// Check if custom page set
		if (View::exists('deployment.pages.terms')) { return view('deployment.pages.terms'); }

	    return view('pages.terms');
	}
}
