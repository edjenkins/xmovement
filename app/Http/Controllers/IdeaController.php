<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Config;
use DB;
use DynamicConfig;
use Gate;
use Response;
use Input;
use Lang;
use Log;
use MetaTag;
use Redirect;
use ResourceImage;
use Session;
use Carbon\Carbon;

use App\Jobs\SendCreateIdeaEmail;
use App\Jobs\SendInviteEmail;
use App\Jobs\SendDidSupportEmail;
use App\Jobs\SendDesignPhaseOpenEmail;
use App\Jobs\PrePopulateDesignTasks;

use App\Idea;
use App\IdeaCategory;
use App\User;
use App\Supporter;
use App\DesignTask;

// class ResponseObject {
//
// 	public $meta = array();
// 	public $errors = array();
// 	public $data = array();
//
// 	public function __construct()
// 	{
// 		$this->meta['success'] = false;
// 	}
// }

class IdeaController extends Controller
{
  public function api_index(Request $request)
  {
    $response = new ResponseObject();

    $response->meta['success'] = true;

    $sort_type = $request->sort_type;
    $category_id = $request->category_id;

    if ($sort_type == 'shortlist')
    {
      $ideas = Idea::where('shortlisted', true)->with('user')->orderBy('created_at', 'desc')->get();
    }
    else
    {
      if ($category_id)
      {
        $ideas = Idea::where('visibility', 'public')->join('idea_idea_category', 'ideas.id', '=', 'idea_idea_category.idea_id')->where('idea_idea_category.idea_category_id', $category_id)->with('user')->orderBy('created_at', 'desc')->get();
      }
      else
      {
        $ideas = Idea::where('visibility', 'public')->with('user')->orderBy('created_at', 'desc')->get();
      }
    }

    $response->data['ideas'] = $ideas;

    return Response::json($response);
  }

  public function api_categories(Request $request)
  {
    $response = new ResponseObject();

    $response->meta['success'] = true;

    $response->data['categories'] = IdeaCategory::whereNull('parent_id')->where('enabled', true)->orderBy('name', 'asc')->with(['subcategories' => function ($q) {
      $q->orderBy('name', 'asc');
    }])->get();

    return Response::json($response);
  }

  public function api_categories_add(Request $request)
  {
    $response = new ResponseObject();

    $response->meta['success'] = true;

    $idea_category = IdeaCategory::create([
      'name' => $request->name,
      'enabled' => true,
      'parent_id' => ($request->parent_id) ? $request->parent_id : NULL
    ]);

    $response->data['categories'] = IdeaCategory::whereNull('parent_id')->where('enabled', true)->with(['subcategories' => function ($q) {
      $q->orderBy('name', 'asc');
    }])->get();

    return Response::json($response);
  }

  public function api_categories_update(Request $request)
  {
    $response = new ResponseObject();

    $response->meta['success'] = true;

    $idea_category = IdeaCategory::find($request->id);

    if ($request->name) { $idea_category->name = $request->name; }
    if ($request->parent_id) { $idea_category->parent_id = $request->parent_id; }

    $idea_category->save();

    $response->data['categories'] = IdeaCategory::whereNull('parent_id')->where('enabled', true)->with('subcategories')->get();
    $response->data['primary_categories'] = IdeaCategory::whereNull('parent_id')->where('enabled', true)->get();
    $response->data['secondary_categories'] = IdeaCategory::whereNotNull('parent_id')->where('enabled', true)->get();

    return Response::json($response);
  }

  public function api_categories_delete(Request $request)
  {
    $response = new ResponseObject();

    $response->meta['success'] = true;

    $idea_category = IdeaCategory::where([
      'id' => $request->id
    ]);

    $idea_category->delete();

    $response->data['categories'] = IdeaCategory::whereNull('parent_id')->where('enabled', true)->with('subcategories')->get();
    $response->data['primary_categories'] = IdeaCategory::whereNull('parent_id')->where('enabled', true)->get();
    $response->data['secondary_categories'] = IdeaCategory::whereNotNull('parent_id')->where('enabled', true)->get();

    return Response::json($response);
  }

  public function index(Request $request)
  {
    # META
    MetaTag::set('title', Lang::get('meta.ideas_index_title'));
    MetaTag::set('description', Lang::get('meta.ideas_index_description'));
    # META

    return view('ideas.index');
  }

  public function view(Request $request, Idea $idea, $slug = null)
  {
    if ($slug != $idea->slug)
    {
      return redirect()->action('IdeaController@view', [$idea, $idea->slug]);
    }

    if (Idea::where('id', $idea->id)->count() == 0)
    {
          Session::flash('flash_message', trans('flash_message.idea_not_found'));
          Session::flash('flash_type', 'flash-danger');
      return redirect()->action('IdeaController@index');
    }

    // Check if user? is a supporter
    $supported = (Auth::check()) ? Auth::user()->hasSupportedIdea($idea) : false;

    # META
    MetaTag::set('title',  Lang::get('meta.ideas_view_title', ['idea_name' => $idea->name]));
    MetaTag::set('description',  Lang::get('meta.ideas_view_description', ['idea_name' => $idea->name, 'user_name' => $idea->user->name]));
        MetaTag::set('image', ResourceImage::getImage($idea->photo, 'large'));
    # META

    $updates = $idea->updates->sortByDesc(function($update)
    {
      return $update->created_at;
    });

    return view('ideas.view', [
      'idea' => $idea,
      'updates' => $updates,
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
    # META
    MetaTag::set('title',  Lang::get('meta.ideas_view_title', ['idea_name' => $idea->name]));
    MetaTag::set('description',  Lang::get('meta.ideas_view_description', ['idea_name' => $idea->name, 'user_name' => $idea->user->name]));
    MetaTag::set('image', ResourceImage::getImage($idea->photo, 'large'));
    # META

    if (Gate::denies('edit', $idea))
    {
      Session::flash('flash_message', trans('flash_message.no_permission'));
      Session::flash('flash_type', 'flash-warning');

      return redirect()->back();
    }
    else
    {
      $idea = Idea::where('id', $idea->id)->with('categories')->first();
      return view('ideas.edit', ['idea' => $idea]);
    }
  }

  public function store(Request $request)
  {
    if (DynamicConfig::fetchConfig('FIXED_IDEA_DURATION', 0) != 0)
    {
      $request->duration = DynamicConfig::fetchConfig('FIXED_IDEA_DURATION');
    }

    // Validate the idea
    $this->validate($request, [
      'name' => 'required|max:255',
      'description' => 'required|max:2000',
      'photo' => 'required|max:255',
      'visibility' => 'required'
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
      'duration' => $request->duration
    ]);

    // Update idea categories
    $idea->attachCategories($request->category);

    // Pre-populate design tasks with user questions
    if (DynamicConfig::fetchConfig('ALLOW_USER_TO_PRE_POPULATE_DESIGN_TASKS', false))
    {
      $questions = [];
      foreach ($request->questions as $index => $question)
      {
        if (($question != "") && ($question !== null))
        {
          array_push($questions, $question);
        }
      }
      $request->questions = $questions;

      foreach ($request->questions as $index => $question)
      {
        $idea->addDesignTask($question, $question, 'Discussion');
      }
    }

    // Populate design tasks from configuration file
    if (DynamicConfig::fetchConfig('PRE_POPULATE_DESIGN_TASKS', false))
    {
          $job = (new PrePopulateDesignTasks($idea))->onQueue('emails');
          $job->handle();
    }

    // Send user an email to tell them the idea was created
        $job = (new SendCreateIdeaEmail($request->user(), $idea))->delay(30)->onQueue('emails');
        $this->dispatch($job);

    // Set creator as a supporter
    $idea->supporters()->attach($request->user()->id); // TODO: Check this works

    // Set states
    $idea->support_state = $idea->support_state();
    $idea->design_state = $idea->design_state();
    $idea->proposal_state = $idea->proposal_state();
    $idea->tender_state = $idea->tender_state();
    $idea->save();

    // Redirect to invite view
    // return redirect()->action('IdeaController@invite', $idea);

    return redirect()->action('IdeaController@view', $idea);
  }

  public function update(Request $request)
  {
    Log::info('Updating idea');

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
        'description' => 'required|max:2000',
        'photo' => 'required|max:255',
      ]);

      if ($request->name) { $idea->name = $request->name; }
      if ($request->visibility) { $idea->visibility = $request->visibility; }
      if ($request->description) { $idea->description = $request->description; }
      if ($request->photo) { $idea->photo = $request->photo; }

      // Update idea categories
      $idea->attachCategories($request->category);

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

  public function openDesignPhase(Request $request, Idea $idea)
  {
    if (Gate::denies('open_design_phase', $idea))
    {
      Session::flash('flash_message', trans('flash_message.no_permission'));
      Session::flash('flash_type', 'flash-warning');
    }
    else
    {
      // Update
      $idea->design_during_support = true;
      $idea->design_state = 'open';
      $idea->save();

      // Send design phase open email
      foreach ($idea->get_supporters() as $index => $supporter)
      {
        $job = (new SendDesignPhaseOpenEmail($supporter->user, $idea))->delay(5)->onQueue('emails');
        $this->dispatch($job);
      }

      Session::flash('flash_message', trans('flash_message.design_phase_opened'));
      Session::flash('flash_type', 'flash-success');
    }

    return redirect()->action('IdeaController@view', $idea);
  }

  public function invite(Request $request, Idea $idea)
  {
    # META
    MetaTag::set('title',  Lang::get('meta.ideas_view_title', ['idea_name' => $idea->name]));
    MetaTag::set('description',  Lang::get('meta.ideas_view_description', ['idea_name' => $idea->name, 'user_name' => $idea->user->name]));
    # META

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

    $resp_success = false;

    if (env('APP_ENV') == 'local')
    {
      $resp_success = true;
    }
    else
    {
      $recaptcha = new \ReCaptcha\ReCaptcha(env('CAPTCHA_SECRET'));
      $resp = $recaptcha->verify($request->captcha, $_SERVER['REMOTE_ADDR']);
      $resp_success = $resp->isSuccess();
    }

    if ($resp_success)
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

      array_push($response->errors, 'Please complete the CAPTCHA below');

      $response->meta['success'] = false;
    }

    $response->data['supporter_count'] = Supporter::where('idea_id', '=', $request->idea_id)->count();

    return Response::json($response);
  }
}
