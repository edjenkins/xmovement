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
use App\DesignModule;
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

            $module['user_vote'] = $module->userVote();
        }
        
        return view('design.dashboard', [
            'idea' => $idea,
            'modules' => $modules,
        ]);
    }

    public function add(Request $request, Idea $idea)
    {
        return view('design.add', [
            'idea' => $idea,
        ]);
    }

    public function vote(Request $request)
    {
        $response = new ResponseObject();

        $value = ($request->vote_direction == 'up') ? 1 : -1;

        $module = DesignModule::whereId($request->votable_id)->first();

        if ($module->addVote($value))
        {
            $response->meta['success'] = true;
        }
        
        return Response::json($response);
    }
}