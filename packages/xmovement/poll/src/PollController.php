<?php

namespace XMovement\Poll;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
 
class PollController extends Controller
{
 
    public static function view()
    {
        return view('poll::view');
    }

}