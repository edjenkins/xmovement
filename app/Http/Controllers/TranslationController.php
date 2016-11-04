<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

use Auth;
use Gate;
use Log;
use Lang;
use MetaTag;
use Response;
use Session;

class ResponseObject {

	public $meta = array();
	public $errors = array();
	public $data = array();

	public function __construct()
	{
		$this->meta['success'] = false;
	}
}

class TranslationController extends Controller
{
    protected $manager;

	public function __construct(\TranslateMate\Manager $manager)
    {
        $this->middleware('auth');

        $this->manager = $manager;
    }

	public function api_index(Request $request)
	{
		$response = new ResponseObject();

		if (Gate::denies('translate', Auth::user()))
		{
            array_push($response->errors, trans('flash_message.no_permission'));

            return Response::json($response);
		}
		else
		{
			$response->meta['success'] = true;

			$this->manager->importTranslations($request->override);

			$response->data['translations'] = $this->manager->fetchTranslations();

			return Response::json($response);
		}
	}

	public function api_find(Request $request)
	{
		$response = new ResponseObject();

		if (Gate::denies('translate', Auth::user()))
		{
            array_push($response->errors, trans('flash_message.no_permission'));

            return Response::json($response);
		}
		else
		{
			$response->meta['success'] = true;

			$response->data['count'] = $this->manager->findTranslations();

			return Response::json($response);
		}
	}

	public function api_update(Request $request)
	{
		$response = new ResponseObject();

		if (Gate::denies('translate', Auth::user()))
		{
            array_push($response->errors, trans('flash_message.no_permission'));

            return Response::json($response);
		}
		else
		{
			$response->meta['success'] = true;

			$response->data['translation'] = $this->manager->updateTranslation($request->translation);

			return Response::json($response);
		}
	}

	public function api_export(Request $request)
	{
		$response = new ResponseObject();

		if (Gate::denies('translate', Auth::user()))
		{
            array_push($response->errors, trans('flash_message.no_permission'));

            return Response::json($response);
		}
		else
		{
			$response->meta['success'] = true;

			$this->manager->exportAllTranslations();

			return Response::json($response);
		}
	}

    public function index()
    {
		# META
		MetaTag::set('title', Lang::get('meta.translation_title'));
		MetaTag::set('description', Lang::get('meta.translation_description'));
		# META

		if (Gate::denies('translate', Auth::user()))
		{
			Session::flash('flash_message', trans('flash_message.no_permission'));
            Session::flash('flash_type', 'flash-danger');

			return redirect()->action('PageController@home');
		}
		else
		{
			return view('translations.index');
		}
    }

}
