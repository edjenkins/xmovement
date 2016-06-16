<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use App\Idea;
use Auth;
use Input;
use Session;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function profile(Request $request, User $user)
	{
		if (is_null($user->id)) { $user = Auth::user(); }

		$supported_ideas = $user->supportedIdeas->take(10);
		$created_ideas = $user->ideas->take(10);

	    return view('users.profile', ['user' => $user, 'supported_ideas' => $supported_ideas, 'created_ideas' => $created_ideas]);
	}

    public function showDetails(Request $request)
	{
		$user = Auth::user();

		return view('users.details', ['user' => $user]);
	}

	public function addDetails(Request $request)
	{
		$user = Auth::user();

		$validation = ['phone' => 'phone:LENIENT,GB,US', 'bio' => 'max:2000'];

		if (isset($request->name)) {
			$validation['name'] = 'required|max:255';
			$user->name = $request->name;
		}

		if (isset($request->email)) {
			$validation['email'] = 'required|email|max:255|unique:users,email,' . $user->id;
			$user->email = $request->email;
		}

		if (isset($request->photo)) {
			$user->avatar = $request->photo;
		}

		$this->validate($request, $validation);

		$user->phone = $request->phone;
		$user->bio = $request->bio;

		$user->save();

		Session::flash('flash_message', trans('flash_message.profile_updated'));
		Session::flash('flash_type', 'flash-success');

	    return redirect()->action('UserController@profile', $user->id);
	}
}
