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
		if ($request->has('cookie_library_study'))
		{
			$request->session()->flash('cookie_library_study', 'no');
		}

	    $ideas = Idea::take(3)->get();

		# META
		MetaTag::set('title', Lang::get('meta.home_title'));
		MetaTag::set('description', Lang::get('meta.home_description'));
		# META

	    return view('pages.home', ['ideas' => $ideas]);
	}

    public function about(Request $request)
	{
		# META
		MetaTag::set('title', Lang::get('meta.about_title'));
		MetaTag::set('description', Lang::get('meta.about_description'));
		# META

		// Check if custom page set
		if (View::exists('custom.pages.about')) { return view('custom.pages.about'); }

		return view('pages.about');
	}

    public function contact(Request $request)
	{
		# META
		MetaTag::set('title', Lang::get('meta.contact_title'));
		MetaTag::set('description', Lang::get('meta.contact_description'));
		# META

	    return view('pages.contact');
	}

    public function terms(Request $request)
	{
		# META
		MetaTag::set('title', Lang::get('meta.terms_title'));
		MetaTag::set('description', Lang::get('meta.terms_description'));
		# META

	    return view('pages.terms');
	}
}
