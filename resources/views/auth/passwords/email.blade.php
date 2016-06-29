@extends('layouts.app', ['bodyclasses' => 'colorful'])

@section('content')

    <div class="page-header colorful">

        <h2 class="main-title">{{ trans('auth.reset_password') }}</h2>

    </div>

    <div class="container">
        <div class="row">

            <div class="auth-panel">

                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                <form class="auth-form" role="form" method="POST" action="{{ url('/password/email') }}">
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

                    <div class="form-group">

                        <button type="submit" class="btn btn-primary">
                            {{ trans('auth.send_reset_email') }}
                        </button>

                    </div>

                </form>


            </div>
        </div>
    </div>

@endsection
