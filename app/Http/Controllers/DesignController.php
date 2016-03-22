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
}