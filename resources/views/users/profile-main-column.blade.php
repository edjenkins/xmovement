<div class="col-sm-7 col-md-8 col-lg-9 profile-main-column">

	<h2 class="user-name hidden-xs">{{ $user->name }}</h2>

	@if ($user->bio != "")

		<p class="user-bio">{{ $user->bio }}</p>

    @else

        @can('edit_preferences', $user)

            <p class="user-bio text-muted">{{ trans('profile.no_bio') }}</p>

        @else

            <br />

        @endcan

	@endif

	@include('users.profile-nav')

	<div class="tab-content">

		@can('edit_preferences', $user)

			<div class="tab-pane fade {{ $viewing_own_profile ? 'in active' : '' }}" id="preferencestab">
				@include('users.preferences')
			</div>

		@endcan

        @can('view_news', $user)

            <div class="tab-pane fade {{ $viewing_own_profile ? '' : 'in active' }}" id="newstab">
                @include('users.news')
            </div>

        @endcan

        @can('view_messages', $user)

            <div class="tab-pane fade" id="messagestab">
            	@include('users.messages')
            </div>

        @endcan

    </div>

</div>
