@extends('layouts.app', ['bodyclasses' => 'colorful'])

@section('content')

    <div class="page-header colorful">

        <h2 class="main-title">{{ trans('auth.reset_password') }}</h2>

    </div>

    <div class="container">
        <div class="row">

            <div class="auth-panel">

                <form class="auth-form" role="form" method="POST" action="{{ url('/password/reset') }}">
                    {!! csrf_field() !!}

                    <input type="hidden" name="token" value="{{ $token }}">

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
                        <label class="control-label">{{ trans('auth.new_password') }}</label>

                        <input type="password" class="form-control input-field" name="password" value="{{ old('password') }}" placeholder="{{ trans('auth.new_password') }}">

                        @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif

                    </div>

                    <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                        <label class="control-label">{{ trans('auth.confirm_password') }}</label>

                        <input type="password" class="form-control input-field" name="password_confirmation" value="{{ old('password_confirmation') }}" placeholder="{{ trans('auth.confirm_password') }}">

                        @if ($errors->has('password_confirmation'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password_confirmation') }}</strong>
                            </span>
                        @endif

                    </div>

                    <div class="form-group">

                        <button type="submit" class="btn btn-primary">
                            {{ trans('auth.reset_password') }}
                        </button>

                    </div>

                </form>


            </div>
        </div>
    </div>

@endsection
