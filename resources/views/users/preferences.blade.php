<div class="preferences-panel">
    <form class="auth-form" role="form" method="POST" action="{{ action('UserController@addDetails') }}">
        {!! csrf_field() !!}

        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            <label class="control-label">{{ trans('auth.name') }}</label>

            <input type="text" class="form-control" name="name" value="{{ old('name', $user->name) }}" placeholder="{{ trans('auth.name') }}">

            @if ($errors->has('name'))
                <span class="help-block">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            <label class="control-label">{{ trans('auth.email_address') }}</label>

            <input type="email" class="form-control" name="email" value="{{ old('email', $user->email) }}" placeholder="{{ trans('auth.email') }}">

            @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group{{ $errors->has('bio') ? ' has-error' : '' }}">
            <label class="control-label">{{ trans('auth.bio') }}</label>

            <input type="text" class="form-control" name="bio" value="{{ old('bio', $user->bio) }}" placeholder="{{ trans('auth.bio_placeholder') }}">

            @if ($errors->has('bio'))
                <span class="help-block">
                    <strong>{{ $errors->first('bio') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
            <label class="control-label">{{ trans('auth.phone_number') }}</label>

            <input type="text" class="form-control" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="{{ trans('auth.phone_number_placeholder') }}">

            @if ($errors->has('phone'))
                <span class="help-block">
                    <strong>{{ $errors->first('phone') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group{{ $errors->has('avatar') ? ' has-error' : '' }}">
            <label class="control-label">{{ trans('auth.avatar') }}</label>

			@include('dropzone', ['type' => 'image', 'cc' => false, 'input_id' => 'avatar', 'value' => old('avatar', $user->avatar), 'dropzone_id' => 1])

            @if ($errors->has('avatar'))
                <span class="help-block">
                    <strong>{{ $errors->first('avatar') }}</strong>
                </span>
            @endif
        </div>

		<div class="form-group{{ $errors->has('header') ? ' has-error' : '' }}">
			<label class="control-label">{{ trans('auth.header_image') }}</label>

			@include('dropzone', ['type' => 'image', 'cc' => false, 'input_id' => 'header', 'value' => old('header', $user->header), 'dropzone_id' => 2])

			@if ($errors->has('header'))
				<span class="help-block">
					<strong>{{ $errors->first('header') }}</strong>
				</span>
			@endif
		</div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">
                {{ trans('auth.update') }}
            </button>
        </div>

    </form>
</div>
