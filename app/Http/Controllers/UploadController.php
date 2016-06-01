<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;

use File;
use Image;
use Input;
use Response;
use Validator;

class UploadController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

	public function save(Request $request)
	{

	}

	public function upload(Request $request)
	{
		$input = Input::all();

		$request_type = $request->type;

		if (isset($request->cc))
		{
			$file = Image::make($request->url);
		}
		else
		{

			if ($request_type == 'image')
			{
				// Image validators

				$rules = array(
				    'file' => 'image|max:3000',
				);

				$validation = Validator::make($input, $rules);

				if ($validation->fails())
				{
					return Response::make($validation->errors()->first(), 400);
				}
			}

			if ($request_type == 'file')
			{
				// File validators

				$rules = array(
				    'file' => 'required|max:10000|mimes:pdf,doc,docx,ppt,pptx,dotx,potx,ppsx,rtf,sldx,txt,xlam,xls,xlsb,xlsx,xltx,.zip',
				);

				$validation = Validator::make($input, $rules);

				if ($validation->fails())
				{
					return Response::make($validation->errors()->first(), 400);
				}
			}

			$file = Input::file('file');
		}

		$extension = (isset($request->cc)) ? 'jpg' : $file->getClientOriginalExtension();

    $filename = sha1(time() . time()) . ".{$extension}";

		if ($request_type == 'file')
		{
			$directory = public_path() .'/uploads/files';

	    if ($file->move($directory, $filename))
			{
	    	return Response::json(array('success' => 200, 'filename' => $filename));
	    }
			else
			{
	    	return Response::json('error', 400);
	    }
		}

		if ($request_type == 'image')
		{
			$directory = public_path() .'/uploads/images';

			$image_sizes = [
				['name' => 'large', 'size' => 1280],
				['name' => 'medium', 'size' => 960],
				['name' => 'small', 'size' => 480],
				['name' => 'thumb', 'size' => 240],
			];

			// Save image sizes
			foreach ($image_sizes as $index => $size)
			{
				$img = Image::make($file);
				$img->resize($size['size'], null, function ($constraint) {
				    $constraint->aspectRatio();
				});
				if (!$img->save($directory . '/' . $size['name'] . '/' . $filename))
				{
					return Response::json('error', 400);
				}
			}

			return Response::json(array('success' => 200, 'filename' => $filename));
		}
	}
}