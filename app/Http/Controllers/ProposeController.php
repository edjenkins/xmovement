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
use App\Proposal;
use App\DesignModule;
use App\DesignTask;
use App\DesignTaskVote;

class ResponseObject {

    public $meta = array();
    public $errors = array();
    public $data = array();

    public function __construct()
    {
        $this->meta['success'] = false;
    }
}

class ProposeController extends Controller
{
    public function index(Request $request, Idea $idea)
    {
        if (Gate::denies('propose', $idea))
        {
            Session::flash('flash_message', trans('flash_message.no_permission'));
            Session::flash('flash_type', 'flash-danger');

            return redirect()->back();
        }

        // Fetch proposals
        $proposals = Proposal::get();

        return view('propose.index', [
            'idea' => $idea,
            'proposals' => $proposals,
        ]);
    }

    public function view(Request $request, Idea $idea)
    {
        // Do nothing
    }

    public function add(Request $request, Idea $idea)
    {
        // Fetch proposals
        $proposals = Proposal::get();

        return view('propose.add', [
            'idea' => $idea,
            'proposals' => $proposals,
        ]);
    }

}
