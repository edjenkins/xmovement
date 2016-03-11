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
use App\Supporter;

class DesignController extends Controller
{
    public function dashboard(Request $request, Idea $idea)
    {
        $ideas = Idea::where('visibility', 'public')->get();

        return view('design.dashboard', [
            'idea' => $idea,
        ]);
    }
}