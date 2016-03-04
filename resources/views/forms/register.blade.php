<form class="auth-form" role="form" method="POST" action="{{ url('/register') }}">
    {!! csrf_field() !!}

    <input type="hidden" name="type" value="{{ $type }}">

    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
        <label class="control-label">Name</label>

        <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Name">

        @if ($errors->has('name'))
            <span class="help-block">
                <strong>{{ $errors->first('name') }}</strong>
            </span>
        @endif

    </div>

    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
        <label class="control-label">Email Address</label>

        <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email">

        @if ($errors->has('email'))
            <span class="help-block">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
        @endif

    </div>

    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
        <label class="control-label">Password</label>

        <input type="password" class="form-control" name="password" placeholder="Password">

        @if ($errors->has('password'))
            <span class="help-block">
                <strong>{{ $errors->first('password') }}</strong>
            </span>
        @endif

    </div>

    @if ($type == 'standard')

        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
            <label class="control-label">Confirm Password</label>

            <input type="password" class="form-control" name="password_confirmation" placeholder="Password">

            @if ($errors->has('password_confirmation'))
                <span class="help-block">
                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                </span>
            @endif

        </div>

    @endif

    <div class="form-group">
        
        <button type="submit" class="btn btn-primary">
            Register
        </button>
        
        @if ($type == 'standard')
        
            <br />
            <a class="btn btn-link muted-link" href="{{ url('/login') }}">Already have an account?</a>
        
        @endif

    </div>

    <div class="text-linethru">
        <div class="line"></div>
        <div class="text">or</div>
    </div>

    <div class="form-group">
        <a class="btn btn-facebook" href="{{ action('Auth\AuthController@redirectToProvider') }}">
            <i class="fa fa-fw fa-facebook"></i>
            Log in with Facebook
        </a>
    </div>

</form>