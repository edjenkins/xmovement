<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;
use Gate;
use Lang;
use Log;
use MetaTag;
use Response;
use Session;

use App\User;
use App\Inspiration;

class ResponseObject {

    public $meta = array();
    public $errors = array();
    public $data = array();

    public function __construct()
    {
        $this->meta['success'] = false;
    }
}

class InspirationController extends Controller
{
	public function api_index(Request $request)
	{
		$response = new ResponseObject();

		$response->meta['success'] = true;

		$response->data['inspirations'] = Inspiration::with('user')->orderBy('created_at', 'desc')->get();

		return Response::json($response);
	}

	public function index(Request $request)
	{
		if (!env('IDEATION_PHASE_ENABLED'))
		{
			// Ideation phase disabled
			Session::flash('flash_message', trans('flash_message.page_not_found'));
            Session::flash('flash_type', 'flash-danger');

			return redirect()->action('PageController@home');
		}

		$inspirations = Inspiration::orderBy('created_at', 'desc');

		# META
		MetaTag::set('title', Lang::get('meta.ideas_index_title'));
		MetaTag::set('description', Lang::get('meta.ideas_index_description'));
		# META

		return view('inspirations.index', [
			'inspirations' => $inspirations,
		]);
	}

    public function add(Request $request)
    {
        $response = new ResponseObject();

		$content = $request->inspiration['content'];

		switch ($request->inspiration['type']) {
			case 'photo':
				# code...
				break;

			case 'video':
				$content = '{"thumbnail":"' . $this->getVideoThumbnail($request->inspiration['content']) . '","embed":"' . $this->getVideoEmbedLink($request->inspiration['content']) . '"}';
				break;

			case 'file':
				# code...
				break;

			case 'link':
				# code...
				break;

			default:
				# code...
				break;
		}

		$inspiration = Inspiration::create([
			'user_id' => Auth::user()->id,
			'type' => $request->inspiration['type'],
            'description' => $request->inspiration['description'],
            'content' => $content,
        ]);


		if ($inspiration)
		{
			$response->meta['success'] = true;
			$response->data['inspiration'] = $inspiration;
			// View::make('xmovement.contribution.contribution-inspiration', ['contributionSubmission' => $contributionSubmission, 'design_task' => $design_task])->render();
		}

        return Response::json($response);
    }

    public function destroy(Request $request)
    {
        $response = new ResponseObject();

		$inspiration_id = $request->inspiration_id;

		$inspiration = Inspiration::find($inspiration_id);

		if (Gate::denies('destroy', $inspiration))
		{
			array_push($response->errors, Lang::get('flash_message.no_permission'));
		}
		else
		{
			$inspiration->delete();

			$response->meta['success'] = true;
		}

        return Response::json($response);
    }

    private function getVideoEmbedLink($value)
    {
        // Check if youtube
        if (preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#", $value, $matches))
        {
            // Valid youtube ID
            return 'http://www.youtube.com/embed/' . $matches[0];
        }
        else
        {
            // Check if vimeo
            if (preg_match("/(?:https?:\/\/)?(?:www\.)?vimeo.com\/(?:channels\/(?:\w+\/)?|groups\/([^\/]*)\/videos\/|album\/(\d+)\/video\/|)(\d+)(?:$|\/|\?)/", $value, $matches)) {
                // Valid vimeo ID
                return 'https://player.vimeo.com/video/' . $matches[3];
            }
            else
            {
                // Not a valid video
                return false;
            }
        }
    }

    private function getVideoThumbnail($value)
    {
        // Check if youtube
        if (preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#", $value, $matches))
        {
            // Valid youtube ID
			return 'http://img.youtube.com/vi/' . $matches[0] . '/hqdefault.jpg';
        }
        else
        {
            // Check if vimeo
            if (preg_match("/(?:https?:\/\/)?(?:www\.)?vimeo.com\/(?:channels\/(?:\w+\/)?|groups\/([^\/]*)\/videos\/|album\/(\d+)\/video\/|)(\d+)(?:$|\/|\?)/", $value, $matches)) {
                // Valid vimeo ID
				$hash = unserialize(file_get_contents('http://vimeo.com/api/v2/video/' . $matches[3] . '.php'));
				return $hash[0]['thumbnail_large'];
            }
            else
            {
                // Not a valid video
                return false;
            }
        }
    }
}
