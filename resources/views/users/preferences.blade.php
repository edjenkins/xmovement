<div class="preferences-panel">
    <form class="auth-form" role="form" method="POST" action="{{ action('UserController@addDetails') }}">
        {!! csrf_field() !!}

        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            <label class="control-label">Name</label>

            <input type="text" class="form-control" name="name" value="{{ old('name', $user->name) }}" placeholder="Name">

            @if ($errors->has('name'))
                <span class="help-block">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            <label class="control-label">Email Address</label>

            <input type="email" class="form-control" name="email" value="{{ old('email', $user->email) }}" placeholder="Email">

            @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group{{ $errors->has('bio') ? ' has-error' : '' }}">
            <label class="control-label">Bio</label>

            <input type="text" class="form-control" name="bio" value="{{ old('bio', $user->bio) }}" placeholder="Say something about yourself">

            @if ($errors->has('bio'))
                <span class="help-block">
                    <strong>{{ $errors->first('bio') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
            <label class="control-label">Phone Number</label>

            <input type="text" class="form-control" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="Your phone number">

            @if ($errors->has('phone'))
                <span class="help-block">
                    <strong>{{ $errors->first('phone') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group{{ $errors->has('avatar') ? ' has-error' : '' }}">
            <label class="control-label">Avatar</label>

			@include('dropzone', ['type' => 'image', 'cc' => false, 'input_id' => 'avatar', 'value' => old('avatar', $user->avatar), 'dropzone_id' => 1])

            @if ($errors->has('avatar'))
                <span class="help-block">
                    <strong>{{ $errors->first('avatar') }}</strong>
                </span>
            @endif
        </div>

		<div class="form-group{{ $errors->has('header') ? ' has-error' : '' }}">
			<label class="control-label">Header Image</label>

			@include('dropzone', ['type' => 'image', 'cc' => false, 'input_id' => 'header', 'value' => old('header', $user->header), 'dropzone_id' => 2])

			@if ($errors->has('header'))
				<span class="help-block">
					<strong>{{ $errors->first('header') }}</strong>
				</span>
			@endif
		</div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">
                Update
            </button>
        </div>

    </form>
</div>
