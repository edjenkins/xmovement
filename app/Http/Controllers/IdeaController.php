<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Response;
use Input;
use Log;

use App\Jobs\SendInviteEmail;

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
    public function index(Request $request)
	{
	    $ideas = Idea::where('visibility', 'public')->get();

	    return view('ideas.index', [
	        'ideas' => $ideas,
	    ]);
	}

    public function view(Request $request, Idea $idea)
	{
		$request->session()->flash('status', 'Task was successful!');

	    return view('ideas.view', [
	    	'idea' => $idea,
	    ]);
	}

    public function add(Request $request)
	{
	    return view('ideas.add');
	}

    public function edit(Request $request, Idea $idea)
	{
	    return view('ideas.edit', [
	    	'idea' => $idea,
	    ]);
	}

	public function store(Request $request)
	{	
		// Validate the idea
	    $this->validate($request, [
	        'name' => 'required|max:255',
	        'visibility' => 'required',
	        'description' => 'required|max:2000',
	        'photo' => 'required|max:255',
	    ]);

	    // Create the idea
	    $idea = $request->user()->ideas()->create([
	        'name' => $request->name,
	        'visibility' => $request->visibility,
	        'description' => $request->description,
	        'photo' => $request->photo,
	    ]);

	    // Redirect to invite view
		return redirect()->action('IdeaController@invite', $idea);
	}

	public function update(Request $request)
	{
		$idea = Idea::find($request->id);

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

		return redirect()->action('IdeaController@view', $idea);
	}

	public function destroy(Request $request, Idea $idea)
	{
	    $this->authorize('destroy', $idea);

		$idea->delete();

		return redirect()->action('IdeaController@index', $idea);
	}

    public function invite(Request $request, Idea $idea)
	{
	    return view('ideas.invite', [
	    	'idea' => $idea,
	    ]);
	}

    public function sendInvites(Request $request)
	{
		$idea = Idea::find($request->id);

		$user = Auth::user();

		$receivers = json_decode($request->data, true);

		foreach ($receivers as $receiver)
		{
			$job = (new SendInviteEmail($user, $receiver, $idea))->onQueue('emails');//->delay(30)

	        $this->dispatch($job);
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
