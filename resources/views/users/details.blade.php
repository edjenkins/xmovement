@extends('layouts.app', ['bodyclasses' => 'colorful'])

@section('content')

    <div class="page-header colorful">

        <h2 class="main-title">{{ trans('details_form.add_details') }}</h2>

    </div>

    <div class="container">
        <div class="row">

            <div class="auth-panel">

				<div class="avatar-wrapper">
					<div class="avatar" style="background-image: url('{{ ResourceImage::getProfileImage($user, 'small') }}')">
					</div>
				</div>

                <form class="auth-form" role="form" method="POST" action="{{ action('UserController@addDetails') }}">
                    {!! csrf_field() !!}

                    <div class="form-group{{ $errors->has('bio') ? ' has-error' : '' }}">
                        <label class="control-label">{{ trans('auth.bio') }}</label>

                        <div class="">
                            <input type="text" class="form-control" name="bio" value="{{ old('bio', $user->bio) }}" placeholder="{{ trans('auth.bio_placeholder') }}">

                            @if ($errors->has('bio'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('bio') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

					@if(false)
	                    <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
	                        <label class="control-label">{{ trans('auth.phone_number') }}</label>

	                        <div class="">
	                            <input type="text" class="form-control" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="{{ trans('auth.phone_number_placeholder') }}">

	                            @if ($errors->has('phone'))
	                                <span class="help-block">
	                                    <strong>{{ $errors->first('phone') }}</strong>
	                                </span>
	                            @endif
	                        </div>
	                    </div>
					@endif

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">
                            {{ trans('details_form.update') }}
                        </button>
                        <br />
                        <a class="btn btn-link muted-link" href="{{ action('UserController@profile') }}">{{ trans('details_form.skip') }}</a>
                    </div>

                </form>
            </div>
        </div>
    </div>

@endsection
