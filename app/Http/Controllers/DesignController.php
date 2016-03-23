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

use App\Idea;
use App\User;
use App\DesignModuleVote;

class ResponseObject {

    public $meta = array();
    public $errors = array();
    public $data = array();

    public function __construct()
    {
        $this->meta['success'] = false;
    }
}

class DesignController extends Controller
{
    public function dashboard(Request $request, Idea $idea)
    {
        $modules = $idea->designModules;

        foreach ($modules as $index => $module)
        {
        	$module['xmovement_module'] = $module->xmovement_module;        	
        }
        
        return view('design.dashboard', [
            'idea' => $idea,
            'modules' => $modules,
        ]);
    }

    public function vote(Request $request)
    {
        $response = new ResponseObject();

        $response->meta['success'] = true;

        $value = ($request->vote_direction == 'up') ? 1 : -1;

        // Check user can vote on module
        // Not locked
        // Update previous votes

        DesignModuleVote::create([
            'design_module_id' => $request->votable_id,
            'user_id' => Auth::user()->id,
            'value' => $value
        ]);

        return Response::json($response);
    }
}