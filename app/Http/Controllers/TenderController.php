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

use App\Idea;
use App\User;
use App\Tender;

class ResponseObject {

    public $meta = array();
    public $errors = array();
    public $data = array();

    public function __construct()
    {
        $this->meta['success'] = false;
    }
}

class TenderController extends Controller
{
    public function index(Request $request, Idea $idea)
    {
		if (Gate::denies('view_tenders', $idea))
		{
	        Session::flash('flash_message', trans('flash_message.tender_phase_closed'));
	        Session::flash('flash_type', 'flash-danger');
			return redirect()->action('IdeaController@view', $idea);
		}

        $tenders = collect($idea->tenders)->sortByDesc(function ($tender, $key) {
            return sprintf('%s', $tender->name);
        })->values()->all();

        return view('tenders.index', [
            'idea' => $idea,
            'tenders' => $tenders,
        ]);
    }

    public function view(Request $request, Tender $tender)
    {
		if (Gate::denies('view_tenders', $tender->idea))
		{
	        Session::flash('flash_message', trans('flash_message.tender_phase_closed'));
	        Session::flash('flash_type', 'flash-danger');
			return redirect()->action('IdeaController@view', $tender->idea);
		}

		$user = Auth::user();

		return view('tenders.view', [
			'tender' => $tender
		]);
    }

    public function add(Request $request, Idea $idea)
    {
		if (Gate::denies('add_tender', $idea))
		{
	        Session::flash('flash_message', trans('flash_message.no_permission'));
	        Session::flash('flash_type', 'flash-danger');
			return redirect()->action('IdeaController@view', $idea);
		}

        // TODO: Complete
    }

    public function destroy(Request $request, Tender $tender)
    {
		if (Gate::denies('destroy', $tender))
		{
	        Session::flash('flash_message', trans('flash_message.no_permission'));
	        Session::flash('flash_type', 'flash-danger');
			return redirect()->action('IdeaController@view', $tender->idea);
		}

		$tender->delete();

		Session::flash('flash_message', trans('flash_message.tender_deleted'));
		Session::flash('flash_type', 'flash-danger');

        return redirect()->action('TenderController@index', $tender->idea);
    }

	public function submit(Request $request)
	{
		$idea = Idea::find($request->session()->get('tender.idea_id'));

		if (Gate::denies('add_tender', $idea))
		{
	        Session::flash('flash_message', trans('flash_message.no_permission'));
	        Session::flash('flash_type', 'flash-danger');
			return redirect()->action('IdeaController@view', $idea);
		}

		$user = Auth::user();

		// Validate the tender
	    $this->validate($request, [
	        'description' => 'required|max:500'
	    ]);

	    // Create the tender
	    Tender::create([
	        'idea_id' => $idea->id,
	        'user_id' => $user->id,
	        'description' => $request->description,
	        'body' => $request->tender
	    ]);

		return redirect()->action('TenderController@index', $idea);
	}

}
