<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

class TranslationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.translate');
    }

    /**
     * Set the application locale.
     *
     * @return \Illuminate\Http\Response
     */
    public function setLocale(Request $request)
    {
		// Set locale
		// \App::setLocale($request->locale);

        return redirect($request->url);
		// return redirect()->action('PageController@home');
    }

}
