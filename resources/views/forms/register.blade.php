<form class="auth-form" role="form" method="POST" action="{{ url('/register') }}">
    {!! csrf_field() !!}

    <input type="hidden" name="type" value="{{ $type }}">

    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
        <label class="control-label">{{ trans('auth.name') }}</label>

        <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="{{ trans('auth.name') }}">

        @if ($errors->has('name'))
            <span class="help-block">
                <strong>{{ $errors->first('name') }}</strong>
            </span>
        @endif

    </div>

    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
        <label class="control-label">{{ trans('auth.email_address') }}</label>

        <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="{{ trans('auth.email') }}">

        @if ($errors->has('email'))
            <span class="help-block">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
        @endif

    </div>

    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
        <label class="control-label">{{ trans('auth.password') }}</label>

        <input type="password" class="form-control" name="password" placeholder="{{ trans('auth.password') }}">

        @if ($errors->has('password'))
            <span class="help-block">
                <strong>{{ $errors->first('password') }}</strong>
            </span>
        @endif

    </div>

    @if ($type == 'standard')

        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
            <label class="control-label">{{ trans('auth.confirm_password') }}</label>

            <input type="password" class="form-control" name="password_confirmation" placeholder="{{ trans('auth.password') }}">

            @if ($errors->has('password_confirmation'))
                <span class="help-block">
                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                </span>
            @endif

        </div>

    @endif

    <div class="form-group">

        <button type="submit" class="btn btn-primary">
            {{ trans('auth.register') }}
        </button>

        @if ($type == 'standard')

            <br />
            <a class="btn btn-link muted-link" href="{{ url('/login') }}">{{ trans('auth.have_an_account') }}</a>

        @endif

    </div>

	@if (env('FACEBOOK_AUTH') || env('LINKEDIN_AUTH'))
	    <div class="text-linethru">
	        <div class="line"></div>
	        <div class="text">{{ trans('common.or') }}</div>
	    </div>
	@endif

	@if (env('FACEBOOK_AUTH'))
	    <div class="form-group">
	        <a class="btn btn-facebook" href="{{ action('Auth\AuthController@redirectToProvider', ['provider' => 'facebook']) }}">
	            <i class="fa fa-fw fa-facebook"></i>
	            {{ trans('auth.facebook_login') }}
	        </a>
	    </div>
	@endif

	@if (env('LINKEDIN_AUTH'))
	    <div class="form-group">
			<a class="btn btn-linkedin" href="{{ action('Auth\AuthController@redirectToProvider', ['provider' => 'linkedin']) }}">
	            <i class="fa fa-fw fa-linkedin"></i>
	            {{ trans('auth.linkedin_login') }}
	        </a>
	    </div>
	@endif

</form>
