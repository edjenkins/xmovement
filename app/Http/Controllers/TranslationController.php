<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

use Log;
use Response;

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

		$response->meta['success'] = true;

		$this->manager->importTranslations(false);

		$response->data['translations'] = $this->manager->fetchTranslations();

		return Response::json($response);
	}

	public function api_update(Request $request)
	{
		$response = new ResponseObject();

		$response->meta['success'] = true;

		$response->data['translation'] = $this->manager->updateTranslation($request->translation);

		return Response::json($response);
	}

	public function api_export(Request $request)
	{
		$response = new ResponseObject();

		$response->meta['success'] = true;

		$this->manager->exportAllTranslations();

		return Response::json($response);
	}

    public function index()
    {
		$translations = [];

		$replace = true;

        return view('translations.index', ['translations' => $translations]);
    }

}
