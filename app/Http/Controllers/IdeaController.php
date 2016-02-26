<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use App\Idea;

class IdeaController extends Controller
{
    public function index(Request $request)
	{
	    $ideas = Idea::get();

	    return view('ideas.index', [
	        'ideas' => $ideas,
	    ]);
	}

    public function view(Request $request, Idea $idea)
	{
	    return view('ideas.view', [
	    	'idea' => $idea,
	    ]);
	}

    public function add(Request $request)
	{
	    return view('ideas.add');
	}

    public function edit(Request $request, Idea $idea)
	{
	    return view('ideas.edit', [
	    	'idea' => $idea,
	    ]);
	}

	public function store(Request $request)
	{
	    $this->validate($request, [
	        'name' => 'required|max:255',
	        'description' => 'required|max:2000',
	        'photo' => 'required|max:255',
	    ]);

	    $request->user()->ideas()->create([
	        'name' => $request->name,
	        'description' => $request->description,
	        'photo' => $request->photo,
	    ]);

		return redirect()->action('IdeaController@index');
	}

	public function update(Request $request)
	{
		$idea = Idea::find($request->id);

	    $this->validate($request, [
	        'name' => 'required|max:255',
	        'description' => 'required|max:2000',
	        'photo' => 'required|max:255',
	    ]);

        $idea->name = $request->name;
        $idea->description = $request->description;
        $idea->photo = $request->photo;

		$idea->save();

		return redirect()->action('IdeaController@view', $idea);
	}
}
