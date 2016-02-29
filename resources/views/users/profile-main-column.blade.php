<div class="col-sm-7 col-md-8 col-lg-9 profile-main-column">

	<h2 class="user-name hidden-xs">{{ $user->name }}</h2>

	@if ($user->bio != "")
	
		<p class="user-bio">{{ $user->bio }}</p>

    @elseif ($user->id == Auth::user()->id)

        <p class="user-bio text-muted">{{ trans('profile.no_bio') }}</p>

    @else

        <br />

	@endif

	@include('users.profile-nav')
	
	<div class="tab-content">
        <div class="tab-pane fade in active" id="newstab">
            @include('users.news')
        </div>
        <div class="tab-pane fade" id="messagestab">
        	@include('users.messages')
        </div>
        <div class="tab-pane fade" id="preferencestab">
            @include('users.preferences')
        </div>
    </div>
    
</div>