<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use App\Jobs\SendWelcomeEmail;
use Intervention\Image\ImageManager;

use Auth;
use Image;
use Input;
use Log;
use Mail;
use Redirect;
use Socialite;
use Session;
use Storage;
use URL;

class AuthController extends Controller
{
    /**
     * Redirect the user to the Facebook authentication page.
     *
     * @return Response
     */
    public function redirectToProvider()
    {
        Session::reflash();

        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Obtain the user information from Facebook.
     *
     * @return Response
     */
    public function handleProviderCallback()
    {
        try {
            $user = Socialite::driver('facebook')->user();
        } catch (Exception $e) {
            return Redirect::to('auth/facebook');
        }

        $authUser = $this->findOrCreateUser($user);

        Auth::login($authUser, true);

        return Redirect::to($this->getRedirectPath());
    }

    /**
     * Return user if exists; create and return if doesn't
     *
     * @param $facebookUser
     * @return User
     */
    private function findOrCreateUser($facebookUser)
    {
        if ($authUser = User::where('facebook_id', $facebookUser->id)->first()) {
            return $authUser;
        }

		$extension = 'jpg';

	    $filename = sha1(time() . time()) . ".{$extension}";

		$image_sizes = [
			['name' => 'large', 'size' => 1280],
			['name' => 'medium', 'size' => 960],
			['name' => 'small', 'size' => 480],
			['name' => 'thumb', 'size' => 240],
		];

		// Save image sizes
		foreach ($image_sizes as $index => $size)
		{
			$img = Image::make(file_get_contents($facebookUser->avatar_original));

			$img->resize($size['size'], null, function ($constraint) {
			    $constraint->aspectRatio();
			});

			$img = $img->stream();

			$path = 'uploads/images/' . $size['name'] . '/';

	        if (!Storage::disk('s3')->put($path.$filename, $img->__toString(), 'public'))
			{
	        	Log::error('Failed to save user avatar from Facebook - ' . $facebookUser->email);
	        }
			else {
				Log::error('Saved to - ' . $path.$filename);
			}
		}

        $user = User::create([
            'facebook_id' => $facebookUser->id,
            'name' => $facebookUser->name,
            'email' => $facebookUser->email,
            'avatar' => $filename,
            'token' => $facebookUser->token
        ]);

        $job = (new SendWelcomeEmail($user, true))->delay(30)->onQueue('emails');

        $this->dispatch($job);

        return $user;
    }

    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins {
        AuthenticatesAndRegistersUsers::login as parentLogin;
        AuthenticatesAndRegistersUsers::register as parentRegister;
    }

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    public function getRedirectPath()
    {
        if (Session::has('redirect'))
        {
            Session::flash('show_support', true);
            return Session::pull('redirect');
        }

        return ((!strlen(Auth::user()->phone)) || (!strlen(Auth::user()->bio))) ? action('UserController@showDetails') : action('UserController@profile', Auth::user()->id);
    }

    protected function redirectPath()
    {
        return $this->getRedirectPath();
    }

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        if ($data['type'] == 'quick')
        {
            $validator = Validator::make($data, [
            'name' => 'required|max:20',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6',
            ]);
        }
        else
        {
            $validator = Validator::make($data, [
            'name' => 'required|max:20',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
            ]);
        }

        return $validator;
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        $job = (new SendWelcomeEmail($user, false))->delay(30)->onQueue('emails');

        $this->dispatch($job);

        return $user;
    }

    public function login(Request $request)
    {
        Session::flash('show_support', true);

        Session::flash('auth_type', 'login');

        return $this->parentLogin($request);
    }

    public function register(Request $request)
    {
        Session::flash('show_support', true);

        Session::flash('auth_type', 'register');

        return $this->parentRegister($request);
    }
}
