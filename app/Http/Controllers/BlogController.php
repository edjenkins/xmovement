<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Config;
use DB;
use DynamicConfig;
use Gate;
use Response;
use Input;
use Lang;
use Log;
use MetaTag;
use Redirect;
use ResourceImage;
use Session;
use Carbon\Carbon;

use App\BlogPost;
use App\User;

class ResponseObject {

	public $meta = array();
	public $errors = array();
	public $data = array();

	public function __construct()
	{
		$this->meta['success'] = false;
	}
}

class BlogController extends Controller
{
	public function index(Request $request)
	{
		$blog_posts = BlogPost::where('visibility', 'public')->with('user')->orderBy('created_at', 'desc')->get();

		# META
		MetaTag::set('title', Lang::get('meta.blog_index_title'));
		MetaTag::set('description', Lang::get('meta.blog_index_description'));
		# META

		return view('blog.index', [
			'blog_posts' => $blog_posts,
		]);
	}

	public function view(Request $request, BlogPost $blog_post, $slug = null)
	{
		if ($slug != $blog_post->slug)
		{
			return redirect()->action('BlogController@view', [$blog_post, $blog_post->slug]);
		}

		if (BlogPost::where('id', $blog_post->id)->count() == 0)
		{
	        Session::flash('flash_message', trans('flash_message.post_not_found'));
	        Session::flash('flash_type', 'flash-danger');
			return redirect()->action('BlogController@index');
		}

		# META
		MetaTag::set('title',  Lang::get('meta.blog_post_view_title', ['blog_post_title' => $blog_post->title]));
		MetaTag::set('description',  Lang::get('meta.blog_post_description', ['idea_name' => $blog_post->title, 'user_name' => $blog_post->user->name]));
        MetaTag::set('image', ResourceImage::getImage($blog_post->photo, 'large'));
		# META

		return view('blog.view', [
			'blog_post' => $blog_post
		]);
	}

}
