<?php

namespace App\Http\Controllers\Auth;

use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Intervention\Image\ImageManager;

use App\Jobs\SendWelcomeEmail;

use Auth;
use Image;
use Input;
use LinkedIn;
use Log;
use Mail;
use Redirect;
use Socialite;
use Session;
use Storage;
use URL;

use App\User;
use App\SocialProfile;

class AuthController extends Controller
{
	use AuthenticatesAndRegistersUsers;

    /**
     * Redirect the user to the authentication page.
     *
     * @return Response
     */
    public function redirectToProvider(Request $request)
    {
        Session::reflash();

		if ($request->provider == 'shibboleth')
		{
			$callback_url = URL::action('Auth\AuthController@handleProviderCallback', ['provider' => 'shibboleth']);

			return Redirect::to('https://gateway.eventmovement.co.uk/shibboleth.php?callback_url=' . $callback_url . '&laravel_session=' . $request->cookie('laravel_session'));
		}
		else
		{
			return Socialite::driver($request->provider)->redirect();
		}
    }

    /**
     * Obtain the user information from Facebook.
     *
     * @return Response
     */
    public function handleProviderCallback(Request $request)
    {
		// Shibboleth auth
		if ($request->provider == 'shibboleth')
		{
			$session_id = $request->cookie('laravel_session');

			if (!Redis::exists($session_id . 'SHIB-PERSISTENT-ID'))
			{
				return Redirect::to('auth/' . $request->provider);
			}

			$shib_data = Redis::get($session_id . 'SHIB-DATA');

			$shib_data = json_decode($shib_data);

			$bio = NULL;

			if ($shib_data->stafforstudent == 'student')
			{
				// coursetitle/awardtitle
				if (property_exists($shib_data, 'coursetitle'))
				{
					$bio = $shib_data->coursetitle;
				}
				else if (property_exists($shib_data, 'awardtitle'))
				{
					$bio = $shib_data->awardtitle;
				}

			}
			else if ($shib_data->stafforstudent == 'staff')
			{
				// dept, position
				if (property_exists($shib_data, 'position') && property_exists($shib_data, 'dept'))
				{
					$bio = $shib_data->position . ' at ' . $shib_data->dept;
				}
				else if (property_exists($shib_data, 'position'))
				{
					$bio = $shib_data->position;
				}
				else if (property_exists($shib_data, 'dept'))
				{
					$bio = $shib_data->dept;
				}
			}

			$user = [
				'shibboleth_id' => Redis::get($session_id . 'SHIB-PERSISTENT-ID'),
				'name' => Redis::get($session_id . 'SHIB-NAME'),
				'email' => Redis::get($session_id . 'SHIB-EMAIL'),
				'bio' => $bio,
				'shibboleth_data' => $shib_data
			];

			// Remove objects from redis
			Redis::del($session_id . 'SHIB-PERSISTENT-ID');
			Redis::del($session_id . 'SHIB-NAME');
			Redis::del($session_id . 'SHIB-EMAIL');
			Redis::del($session_id . 'SHIB-DATA');
		}
		else
		{
			try {
	            $user = Socialite::driver($request->provider)->user();
	        } catch (Exception $e) {
	            return Redirect::to('auth/' . $request->provider);
	        }
		}

        switch ($request->provider) {
        	case 'shibboleth':
        		$authUser = $this->findOrCreateShibbolethUser($user);
        		break;
        	case 'facebook':
        		$authUser = $this->findOrCreateFacebookUser($user);
        		break;
        	case 'linkedin':
        		$authUser = $this->findOrCreateLinkedinUser($user);
        		break;

        	default:
        		# code...
        		break;
        }

        Auth::login($authUser, true);

        return Redirect::to($this->getRedirectPath());
    }

    /**
     * Return user if exists; create and return if doesn't
     *
     * @param $shibbolethUser
     * @return User
     */
    private function findOrCreateShibbolethUser($shibbolethUser)
    {
        if ($authUser = User::where('shibboleth_id', $shibbolethUser['shibboleth_id'])->first()) {
            return $authUser;
        }

		// TODO: If shibboleth passes an image then save it

        $user = User::create([
            'shibboleth_id' => $shibbolethUser['shibboleth_id'],
            'name' => $shibbolethUser['name'],
			'email' => $shibbolethUser['email'],
			'bio' => $shibbolethUser['bio'],
			'shibboleth_data' => $shibbolethUser['shibboleth_data'],
        ]);

        $job = (new SendWelcomeEmail($user, false))->delay(30)->onQueue('emails');

        $this->dispatch($job);

        return $user;
    }

    /**
     * Return user if exists; create and return if doesn't
     *
     * @param $facebookUser
     * @return User
     */
    private function findOrCreateFacebookUser($facebookUser)
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

        $job = (new SendWelcomeEmail($user, false))->delay(30)->onQueue('emails');

        $this->dispatch($job);

        return $user;
    }

    /**
     * Fetch and store user's LinkedIn profile
     *
     * @param $linkedinUser
     * @return User
     */
    private function fetchLinkedInProfile($linkedinUser, $user)
    {
		// Save the users profile
		LinkedIn::setAccessToken($linkedinUser->token);
		$linkedinProfile = LinkedIn::get('v1/people/~:(id,num-connections,picture-url,positions:(id,title,summary,start-date,end-date,is-current,company:(id,name,type,size,industry,ticker)))');

		SocialProfile::create([
			'user_id' => $user->id,
            'identifier' => $linkedinUser->id,
            'provider' => 'linkedin',
            'profile' => json_encode($linkedinProfile)
        ]);
	}

    /**
     * Return user if exists; create and return if doesn't
     *
     * @param $linkedinUser
     * @return User
     */
    private function findOrCreateLinkedinUser($linkedinUser)
    {
        if ($user = User::where('linkedin_id', $linkedinUser->id)->first()) {

			$this->fetchLinkedInProfile($linkedinUser, $user);

            return $user;
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
			$img = Image::make(file_get_contents($linkedinUser->avatar_original));

			$img->resize($size['size'], null, function ($constraint) {
			    $constraint->aspectRatio();
			});

			$img = $img->stream();

			$path = 'uploads/images/' . $size['name'] . '/';

	        if (!Storage::disk('s3')->put($path.$filename, $img->__toString(), 'public'))
			{
	        	Log::error('Failed to save user avatar from Linkedin - ' . $linkedinUser->email);
	        }
			else {
				Log::error('Saved to - ' . $path.$filename);
			}
		}

        $user = User::create([
            'linkedin_id' => $linkedinUser->id,
            'name' => $linkedinUser->name,
            'email' => $linkedinUser->email,
            'avatar' => $filename,
            'token' => $linkedinUser->token
        ]);

		$this->fetchLinkedInProfile($linkedinUser, $user);

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

        return (!strlen(Auth::user()->bio)) ? action('UserController@showDetails') : action('UserController@profile', Auth::user()->id);
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
            'name' => 'required|max:50',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6',
            ]);
        }
        else
        {
            $validator = Validator::make($data, [
            'name' => 'required|max:50',
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
		if (env('STANDARD_AUTH', true))
		{
	        Session::flash('show_support', true);
	        Session::flash('auth_type', 'login');

	        return $this->parentLogin($request);
		}
		else
		{
			Session::flash('flash_message', trans('flash_message.no_permission'));
            Session::flash('flash_type', 'flash-danger');

			return redirect('/');
		}
    }

    public function register(Request $request)
    {
		if (env('STANDARD_AUTH', true))
		{
	        Session::flash('show_support', true);
	        Session::flash('auth_type', 'register');

	        return $this->parentRegister($request);
		}
		else
		{
			Session::flash('flash_message', trans('flash_message.no_permission'));
            Session::flash('flash_type', 'flash-danger');

			return redirect('/');
		}
    }
}
