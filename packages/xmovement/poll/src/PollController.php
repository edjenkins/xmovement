<?php

namespace XMovement\Poll;

use App\Http\Controllers\Controller;
 
class PollController extends Controller
{
 
    public static function view($module_id)
    {
    	$module = \App\DesignModule::where('id', $module_id)->get()->first();

    	$poll = $module->xmovement_module;

        return view('poll::view', ['poll' => $poll, 'module' => $module]);
    }

}