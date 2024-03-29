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
use App\Team;
use App\Tender;
use App\TenderQuestion;
use App\TenderQuestionAnswer;

class ResponseObject
{
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
    public function api_view(Request $request)
    {
        $response = new ResponseObject();

        $response->meta['success'] = true;

        $tender = Tender::whereId($request->tender_id)->with('team.users', 'answers', 'answers.question', 'updates')->first();

        $response->data['tender'] = $tender;

        return Response::json($response);
    }

    public function index(Request $request, Idea $idea)
    {
        if (Gate::denies('view_tenders', $idea)) {
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
        if (Gate::denies('view_tenders', $tender->idea)) {
            Session::flash('flash_message', trans('flash_message.tender_phase_closed'));
            Session::flash('flash_type', 'flash-danger');
            return redirect()->action('IdeaController@view', $tender->idea);
        }

        return view('tenders.view', [
            'tender' => $tender
        ]);
    }

    public function add(Request $request, Idea $idea)
    {
        if (Gate::denies('submit_tender', $idea)) {
            Session::flash('flash_message', trans('flash_message.no_permission'));
            Session::flash('flash_type', 'flash-danger');
            return redirect()->action('IdeaController@view', $idea);
        }

        $tender_questions = TenderQuestion::where(['enabled' => true])->get();

        return view('tenders.add', [
            'idea' => $idea,
            'tender_questions' => $tender_questions
        ]);
    }

    public function destroy(Request $request, Tender $tender)
    {
        if (Gate::denies('destroy', $tender)) {
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
        $idea = Idea::find($request->idea_id);

        if (Gate::denies('submit_tender', $idea)) {
            Session::flash('flash_message', trans('flash_message.no_permission'));
            Session::flash('flash_type', 'flash-danger');
            return redirect()->action('IdeaController@view', $idea);
        }

        Log::error($request);

        // Validate the tender
        $this->validate($request, [
            'summary' => 'required'
        ]);

        // Create the tender
        $tender = Tender::create([
            'idea_id' => $request->idea_id,
            'user_id' => Auth::user()->id,
            'team_id' => $request->team_id,
            'summary' => $request->summary,
            'document' => $request->document,
            'private_document' => $request->private_document,
        ]);

        if ($request->answers) {
            foreach ($request->answers as $question_id => $answer) {
                $tender_question_answer = TenderQuestionAnswer::create([
                    'tender_id' => $tender->id,
                    'tender_question_id' => $question_id,
                    'answer' => $answer
                ]);

                // $tender->questions()->attach($tender_question_answer->tender_question_id);
            }
        }

        Session::flash('flash_message', trans('flash_message.tender_created'));
        Session::flash('flash_type', 'flash-success');

        return redirect()->action('TenderController@view', $tender);
    }
}
