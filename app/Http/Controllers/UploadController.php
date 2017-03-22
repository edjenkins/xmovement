<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;

use Log;
use File;
use Image;
use Input;
use Response;
use Storage;
use Validator;

class UploadController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

	public function upload(Request $request)
	{
		$input = Input::all();

		$request_type = $request->type;

		if (isset($request->cc))
		{
			if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on")
			{
				$image_url = strtolower($request->url);
			}
			else
			{
				$image_url = str_replace('https', 'http', strtolower($request->url));
			}

			$file = Image::make($image_url);
		}
		else
		{

			if ($request_type == 'image')
			{
				// Image validators

				$rules = array(
				    'file' => 'image|max:20000',
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
				    'file' => 'required|max:20000|mimes:pdf,doc,docx,ppt,pptx,dotx,potx,ppsx,rtf,sldx,txt,xlam,xls,xlsb,xlsx,xltx,.zip',
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

			$path = 'uploads/files/';

			if (!Storage::disk('s3')->put($path.$filename,  file_get_contents($file), 'public'))
			{
				return Response::json('error', 400);
		    }
			return Response::json(array('success' => 200, 'filename' => $filename));
		}

		if ($request_type == 'image')
		{
			$directory = public_path() .'/uploads/images';

			$image_sizes = [
				['name' => 'large', 'size' => 1280],
				['name' => 'medium', 'size' => 960],
				['name' => 'small', 'size' => 480],
				['name' => 'thumb', 'size' => 240],
				['name' => 'banner', 'size' => 200],
			];

			// Save image sizes
			foreach ($image_sizes as $index => $size)
			{
				$img = Image::make($file);

				if ($size['name'] == 'banner')
				{
					$img->fit(1080, 320);
				}
				else
				{
					$img->resize($size['size'], null, function ($constraint) {
					    $constraint->aspectRatio();
					});
				}

		        $img = $img->stream();

				$path = 'uploads/images/' . $size['name'] . '/';

		        if (!Storage::disk('s3')->put($path.$filename, $img->__toString(), 'public'))
				{
		        	return Response::json('error', 400);
		        }
			}

			return Response::json(array('success' => 200, 'filename' => $filename));
		}
	}
}
