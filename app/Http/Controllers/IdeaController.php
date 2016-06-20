<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Gate;
use Response;
use Input;
use Log;
use Session;
use Carbon\Carbon;

use App\Jobs\SendInviteEmail;
use App\Jobs\SendDidSupportEmail;

use App\Idea;
use App\User;
use App\Supporter;

class ResponseObject {

	public $meta = array();
	public $errors = array();
	public $data = array();

	public function __construct()
	{
		$this->meta['success'] = false;
	}
}

class IdeaController extends Controller
{
	public function api_index(Request $request)
	{
		$response = new ResponseObject();

		$response->meta['success'] = true;

		$response->data['ideas'] = Idea::where('visibility', 'public')->with('user')->orderBy('created_at', 'desc')->get();

		return Response::json($response);
	}

	public function index(Request $request)
	{
		$ideas = Idea::where('visibility', 'public')->orderBy('created_at', 'desc')->get();

		return view('ideas.index', [
			'ideas' => $ideas,
		]);
	}

	public function view(Request $request, Idea $idea)
	{
		// Check if user? is a supporter
		$supported = (Auth::check()) ? Auth::user()->hasSupportedIdea($idea) : false;

		return view('ideas.view', [
			'idea' => $idea,
			'supported' => $supported
		]);
	}

	public function add(Request $request)
	{
		if (Auth::check())
		{
			return view('ideas.add');
		}
		else
		{
			Session::flash('redirect', $request->url());
			return view('ideas.learn');
		}
	}

	public function edit(Request $request, Idea $idea)
	{
		if (Gate::denies('edit', $idea))
		{
			Session::flash('flash_message', trans('flash_message.no_permission'));
			Session::flash('flash_type', 'flash-warning');

			return redirect()->back();
		}
		else
		{
			return view('ideas.edit', ['idea' => $idea]);
		}
	}

	public function store(Request $request)
	{
		// Validate the idea
		$this->validate($request, [
			'name' => 'required|max:255',
			'description' => 'required|max:2000',
			'photo' => 'required|max:255',
			'visibility' => 'required',
			'duration' => 'integer|between:5,45',
			'design_during_support' => 'required|boolean',
			'proposals_during_design' => 'required|boolean',
		]);

		// Create the idea
		$idea = $request->user()->ideas()->create([
			'name' => $request->name,
			'description' => $request->description,
			'photo' => $request->photo,
			'visibility' => $request->visibility,
			'support_state' => 'open',
			'design_state' => ($request->design_during_support) ? 'open' : 'closed',
			'proposal_state' => 'closed',
			'supporters_target' => $request->supporters_target,
			'duration' => $request->duration,
			'design_during_support' => $request->design_during_support,
			'proposals_during_design' => $request->proposals_during_design,
		]);

		// Redirect to invite view
		return redirect()->action('IdeaController@invite', $idea);
	}

	public function update(Request $request)
	{
		$idea = Idea::find($request->id);

		if (Gate::denies('edit', $idea))
		{
			Session::flash('flash_message', trans('flash_message.no_permission'));
			Session::flash('flash_type', 'flash-warning');
		}
		else
		{
			$this->validate($request, [
				'name' => 'required|max:255',
				'visibility' => 'required',
				'description' => 'required|max:2000',
				'photo' => 'required|max:255',
			]);

			$idea->name = $request->name;
			$idea->visibility = $request->visibility;
			$idea->description = $request->description;
			$idea->photo = $request->photo;

			$idea->save();

			Session::flash('flash_message', trans('flash_message.idea_updated'));
			Session::flash('flash_type', 'flash-success');
		}

		return redirect()->action('IdeaController@view', $idea);
	}

	public function destroy(Request $request, Idea $idea)
	{
		if (Gate::denies('destroy', $idea))
		{
			Session::flash('flash_message', trans('flash_message.no_permission'));
			Session::flash('flash_type', 'flash-warning');
		}
		else
		{
			$idea->delete();

			Session::flash('flash_message', trans('flash_message.idea_deleted'));
			Session::flash('flash_type', 'flash-danger');
		}

		return redirect()->action('IdeaController@index', $idea);
	}

	public function invite(Request $request, Idea $idea)
	{
		if (Gate::denies('invite', $idea))
		{
			return redirect()->action('IdeaController@view', $idea);
		}
		else
		{
			return view('ideas.invite', ['idea' => $idea]);
		}
	}

	public function sendInvites(Request $request, Idea $idea)
	{
		$user = Auth::user();

		if (Gate::denies('invite', $idea))
		{
			Session::flash('flash_message', trans('flash_message.invites_not_sent'));
			Session::flash('flash_type', 'flash-danger');
		}
		else
		{
			$receivers = json_decode($request->data, true);

			foreach ($receivers as $receiver)
			{
				$job = (new SendInviteEmail($user, $receiver, $idea))->onQueue('emails');//->delay(30)

				$this->dispatch($job);
			}

			Session::flash('flash_message', trans('flash_message.invites_sent_successfully'));
			Session::flash('flash_type', 'flash-success');
		}

		return redirect()->action('IdeaController@view', $idea);
	}

	/**
	* Make given User a supporter of a given Idea
	*
	* @param  int  $user_id
	* @param  int  $idea_id
	* @param  string  $captcha
	* @return ResponseObject $response
	*/
	public function support(Request $request)
	{
		$response = new ResponseObject();

		$recaptcha = new \ReCaptcha\ReCaptcha(getenv('CAPTCHA_SECRET'));

		$resp = $recaptcha->verify($request->captcha, $_SERVER['REMOTE_ADDR']);

		if ($resp->isSuccess())
		{
			$idea = Idea::find($request->idea_id);

			$idea->supporters()->attach($request->user_id);

			$receiver = User::find($request->user_id);

			if ($idea->user_id != $receiver->id)
			{
				$job = (new SendDidSupportEmail($idea->user, $receiver, $idea))->onQueue('emails');
				$this->dispatch($job);
			}

			$response->meta['success'] = true;

		} else {

			// $resp->getErrorCodes()

			array_push($response->errors, 'Please complete the CAPTCHA below');

			$response->meta['success'] = false;
		}

		$response->data['supporter_count'] = Supporter::where('idea_id', '=', $request->idea_id)->count();

		return Response::json($response);
	}
}
