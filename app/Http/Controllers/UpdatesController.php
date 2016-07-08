<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Gate;
use Response;
use Input;
use Lang;
use Log;
use View;
use Carbon\Carbon;

use App\Jobs\SendUpdatePostedEmail;

use App\Idea;
use App\User;
use App\Update;

class ResponseObject {

	public $meta = array();
	public $errors = array();
	public $data = array();

	public function __construct()
	{
		$this->meta['success'] = false;
	}
}

class UpdatesController extends Controller
{
	public function add(Request $request)
	{
		// Get the idea

		$idea = Idea::whereId($request->idea_id)->first();

		// Save update

		$update = Update::create([
			'user_id' => Auth::user()->id,
			'idea_id' => $idea->id,
			'text' => nl2br(htmlentities($request->text, ENT_QUOTES, 'UTF-8'))
		]);

		// Notify users via email

		// Check if users are being spammed
		$recent_update_count = Update::where([['idea_id', $idea->id], ['created_at', '>=', Carbon::now()->subDay()]])->count();

		Log::info('Updates sent today - ' . $recent_update_count);

		if ($recent_update_count < 2)
		{
			foreach ($idea->get_supporters() as $index => $supporter)
			{
				$job = (new SendUpdatePostedEmail(Auth::user(), $supporter->user, $idea, $update))->delay(5)->onQueue('emails');
				$this->dispatch($job);
			}
		}
		else
		{
			Log::error('Can only send 2 updates per day');
		}

		// Return JSON response

		$response = new ResponseObject();

		$response->meta['success'] = true;

		$response->data['element'] = View::make('ideas.update', ['update' => $update])->render();

		return Response::json($response);
	}

	public function destroy(Request $request)
	{
		$update = Update::whereId($request->update_id)->first();

		$response = new ResponseObject();

		if (Gate::denies('destroyUpdate', $update->idea))
		{
            array_push($response->errors, trans('flash_message.no_permission'));

            return Response::json($response);
		}
		else
		{
			$update->delete();

			$response->meta['success'] = true;

			return Response::json($response);
		}

	}

}
