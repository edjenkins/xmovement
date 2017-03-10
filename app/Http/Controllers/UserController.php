<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use App\Idea;
use Auth;
use Input;
use Log;
use Redirect;
use Response;
use Session;

use Illuminate\Http\Request;

class ResponseObject {

	public $meta = array();
	public $errors = array();
	public $data = array();

	public function __construct()
	{
		$this->meta['success'] = false;
	}
}

class UserController extends Controller
{
	public function api_search(Request $request)
	{
		$response = new ResponseObject();

		$response->meta['success'] = true;

		$name = $request->name;

		$response->data['users'] = (strlen($name) > 2) ? User::where('name', 'like', '%' . $name .'%')->select('id', 'name', 'avatar')->orderBy('name')->get() : [];

		return Response::json($response);
	}

	public function api_get_admins(Request $request)
	{
		$response = new ResponseObject();

		$response->meta['success'] = true;

		$response->data['users'] = User::where('super_admin', true)
		->orWhere('can_manage_admins', true)
		->orWhere('can_manage_platform', true)
		->orWhere('can_translate', true)
		->orWhere('can_view_analytics', true)
		->select('id', 'name', 'avatar')->orderBy('name')->get();

		return Response::json($response);
	}

    public function profile(Request $request, User $user)
	{
		if (is_null($user->id)) { $user = Auth::user(); }

		if (!$user) {
			Session::flash('flash_message', trans('flash_message.user_not_found'));
			Session::flash('flash_type', 'flash-danger');

		    return redirect()->action('PageController@home');
		}
		$supported_ideas = $user->supportedIdeas->take(10);
		$created_ideas = $user->ideas->take(10);

		$viewing_own_profile = false;
		if (Auth::user())
		{
			if (Auth::user()->id == $user->id) {
				$viewing_own_profile = true;
			}
		}

		# META
		MetaTag::set('title', $user->name);
		MetaTag::set('description', Lang::get('meta.profile_description'));
		# META

	    return view('users.profile', ['user' => $user, 'supported_ideas' => $supported_ideas, 'created_ideas' => $created_ideas, 'viewing_own_profile' => $viewing_own_profile]);
	}

    public function showDetails(Request $request)
	{
		# META
		MetaTag::set('title', Lang::get('meta.user_details_title'));
		MetaTag::set('description', Lang::get('meta.user_details_description'));
		# META

		$user = Auth::user();

		if (!$user) {
			Session::flash('flash_message', trans('flash_message.user_not_found'));
			Session::flash('flash_type', 'flash-danger');

		    return redirect()->action('PageController@home');
		}

		return view('users.details', ['user' => $user]);
	}

	public function addDetails(Request $request)
	{
		$user = Auth::user();

		$validation = ['phone' => 'phone:LENIENT,GB,US', 'bio' => 'max:2000'];

		if (isset($request->name)) {
			$validation['name'] = 'required|max:50';
			$user->name = $request->name;
		}

		if (isset($request->email)) {
			$validation['email'] = 'required|email|max:255|unique:users,email,' . $user->id;
			$user->email = $request->email;
		}

		if (isset($request->avatar)) {
			$user->avatar = $request->avatar;
		}

		if (isset($request->header)) {
			$user->header = $request->header;
		}

		$this->validate($request, $validation);

		$user->phone = $request->phone;
		$user->bio = $request->bio;

		$user->save();

		Session::flash('flash_message', trans('flash_message.profile_updated'));
		Session::flash('flash_type', 'flash-success');

		if (Session::has('temp_redirect'))
		{
			return Redirect::to(Session::pull('temp_redirect'));
		}
		else
		{
			return Redirect::to(Session::pull('redirect'));
		}
	}
}
