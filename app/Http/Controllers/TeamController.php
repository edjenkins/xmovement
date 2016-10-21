<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use Gate;
use Response;
use Input;
use Log;
use Session;

use App\Team;
use App\User;

class TeamController extends Controller
{
	public function api_index(Request $request)
	{
		$response = new ResponseObject();

		$response->meta['success'] = true;

		$user_id = Auth::user()->id;

		$response->data['teams'] = Team::where('user_id', $user_id)->get();

		return Response::json($response);
	}

	public function api_search(Request $request)
	{
		$response = new ResponseObject();

		$response->meta['success'] = true;

		$name = $request->name;

		$team_id = $request->team_id;

		$response->data['users'] = User::whereDoesntHave('teams', function ($query) use ($team_id) {

			$query->where('id', $team_id);

		})->where('name', 'like', '%' . $name .'%')->select('id', 'name', 'avatar')->orderBy('name')->get();

		return Response::json($response);
	}

	public function api_add_user(Request $request)
	{
		$response = new ResponseObject();

		$team = Team::find($request->team_id);

		if (Gate::denies('add_user', $team))
		{
            array_push($response->errors, trans('flash_message.no_permission'));

            return Response::json($response);
		}
		else
		{
			$response->meta['success'] = true;

			$team->users()->sync([$request->user_id], false);

			$team->save();

			// TODO: Send email notifying the user of their addition to the team

			$response->data['team'] = $team;

			return Response::json($response);
		}
	}

	public function api_remove_user(Request $request)
	{
		$response = new ResponseObject();

		$team = Team::find($request->team_id);

		if (Gate::denies('remove_user', $team))
		{
            array_push($response->errors, trans('flash_message.no_permission'));

            return Response::json($response);
		}
		else
		{
			$response->meta['success'] = true;

			$team->users()->detach([$request->user_id]);

			$team->save();

			// TODO: Send email notifying the user of their removal from the team

			$response->data['team'] = $team;

			return Response::json($response);
		}
	}

	public function submit(Request $request)
	{
		if (Auth::user()->cannot('create', Team::class))
		{
		    Session::flash('flash_message', trans('flash_message.no_permission'));
	        Session::flash('flash_type', 'flash-danger');
			return redirect()->back();
		}

		$user = Auth::user();

		// Validate the team
	    $this->validate($request, [
	        'name' => 'required',
			'bio' => 'required',
			'email' => 'required'
	    ]);

		$team = Team::create([
			'user_id' => Auth::user()->id,
	        'name' => $request->name,
			'bio' => $request->bio,
			'email' => $request->email,
			'avatar' => $request->avatar,
		]);

        Session::flash('flash_message', trans('flash_message.team_created'));
        Session::flash('flash_type', 'flash-success');

		return redirect()->back();
	}

}
