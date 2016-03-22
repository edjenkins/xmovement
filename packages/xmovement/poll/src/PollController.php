<?php

namespace XMovement\Poll;

use App\Http\Controllers\Controller;
 
class PollController extends Controller
{
 
    public static function view($poll_id)
    {
    	$poll = Poll::find($poll_id)->with('pollOptions')->get()->first();

        return view('poll::view', ['poll' => $poll]);
    }

}