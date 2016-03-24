<?php

namespace XMovement\Poll;

use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;
use DB;
use Gate;
use Response;
use Input;
use Log;
use Session;

use App\Idea;
use App\User;
use App\DesignModuleVote;




use App\Http\Controllers\Controller;


class ResponseObject {

    public $meta = array();
    public $errors = array();
    public $data = array();

    public function __construct()
    {
        $this->meta['success'] = false;
    }
}
 
class PollController extends Controller
{
 
    public static function view($module_id)
    {
    	$module = \App\DesignModule::where('id', $module_id)->get()->first();
    	
    	$poll = $module->xmovement_module;

        return view('poll::view', ['poll' => $poll, 'module' => $module]);
    }

    public function vote(Request $request)
    {
        $response = new ResponseObject();

        $value = ($request->vote_direction == 'up') ? 1 : -1;

        $poll_option = PollOption::whereId($request->votable_id)->first();

        if ($poll_option->addVote($value))
        {
            $response->meta['success'] = true;
        }
        
        return Response::json($response);
    }

}