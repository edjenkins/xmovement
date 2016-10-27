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
		$response = new ResponseObject();

		// TODO: Validation

		// Save update
		$update = Update::create([
			'user_id' => Auth::user()->id,
			'updateable_type' => $request->updateable_type,
			'updateable_id' => $request->updateable_id,
			'text' => nl2br(htmlentities($request->text, ENT_QUOTES, 'UTF-8'))
		]);

		$response->data['update'] = $update;

		switch ($update->updateable_type) {
			case 'idea':

				Log::info('Posting idea update');

				$idea = Idea::whereId($update->updateable_id)->first();

				// Notify users unless they have received more than two emails in past day
				$recent_update_count = Update::where([['updateable_id', $idea->id], ['updateable_type', 'idea'], ['created_at', '>=', Carbon::now()->subDay()]])->count();

				if ($recent_update_count < 2)
				{
					foreach ($idea->get_supporters() as $index => $supporter)
					{
						$job = (new SendUpdatePostedEmail(Auth::user(), $supporter->user, $idea, $update))->delay(5)->onQueue('emails');
						$this->dispatch($job);
					}
				}

				// Render element for response
				$response->data['element'] = View::make('ideas.update', ['update' => $update])->render();

				$response->meta['success'] = true;

				break;

			case 'tender':

				Log::info('Posting tender update');

				// Render element for response
				$response->data['element'] = View::make('tenders.update', ['update' => $update])->render();

				$response->meta['success'] = true;

				break;

			default:

				$response->meta['success'] = false;

				break;
		}

		// Return JSON response

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
