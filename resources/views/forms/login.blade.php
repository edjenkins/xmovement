<form class="auth-form" role="form" method="POST" action="{{ url('/login') }}">
    {!! csrf_field() !!}

    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
        <label class="control-label">{{ trans('auth.email_address') }}</label>

        <input type="email" class="form-control input-field" name="email" value="{{ old('email') }}" placeholder="{{ trans('auth.email') }}">

        @if ($errors->has('email'))
            <span class="help-block">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
        @endif

    </div>

    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
        <label class="control-label">{{ trans('auth.password') }}</label>

        <input type="password" class="form-control input-field" name="password" placeholder="{{ trans('auth.password') }}">

        @if ($errors->has('password'))
            <span class="help-block">
                <strong>{{ $errors->first('password') }}</strong>
            </span>
        @endif

    </div>

    <div class="form-group visuallyhidden">
        <div class="checkbox">
            <label>
                <input type="checkbox" name="remember"> {{ trans('auth.remember_me') }}
            </label>
        </div>
    </div>

    <div class="form-group">

        <button type="submit" class="btn btn-primary">
            {{ trans('auth.login') }}
        </button>

        <br />

        <a class="btn btn-link muted-link" href="{{ url('/password/reset') }}">{{ trans('auth.forgot_your_password') }}</a>

    </div>

    <div class="text-linethru">
        <div class="line"></div>
        <div class="text">{{ trans('common.or') }}</div>
    </div>

    <div class="form-group">
        <a class="btn btn-facebook" href="{{ action('Auth\AuthController@redirectToProvider') }}">
            <i class="fa fa-fw fa-facebook"></i>
            {{ trans('auth.facebook_login') }}
        </a>
    </div>

    <div class="form-group">
        <a class="btn btn-linkedin" href="{{ action('Auth\AuthController@redirectToProvider') }}">
            <i class="fa fa-fw fa-linkedin"></i>
            {{ trans('auth.linkedin_login') }}
        </a>
    </div>

</form>
