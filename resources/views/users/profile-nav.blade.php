<div class="profile-nav">
	<ul>

		@can('editPreferences', $user)

			<li class="{{ $viewing_own_profile ? 'active' : '' }}"><a href="#preferencestab" data-toggle="tab">{{ trans('profile.preferences') }}</a></li>

		@endcan

		@can('viewNews', $user)

			<li class="{{ $viewing_own_profile ? '' : 'active' }}"><a href="#newstab" data-toggle="tab">{{ trans('profile.news') }}</a></li>

		@endcan

		@can('viewMessages', $user)

			<li><a href="#messagestab" data-toggle="tab">{{ trans('profile.messages') }}</a></li>

		@endcan

	</ul>
</div>
