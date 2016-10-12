<div class="profile-nav">
	<ul>

		@can('edit_preferences', $user)

			<li class="{{ $viewing_own_profile ? 'active' : '' }}"><a href="#preferencestab" data-toggle="tab">{{ trans('profile.preferences') }}</a></li>

		@endcan

		@can('view_news', $user)

			<li class="{{ $viewing_own_profile ? '' : 'active' }}"><a href="#newstab" data-toggle="tab">{{ trans('profile.news') }}</a></li>

		@endcan

		@can('view_messages', $user)

			<li><a href="#messagestab" data-toggle="tab">{{ trans('profile.messages') }}</a></li>

		@endcan

		<div class="clearfloat"></div>

	</ul>
</div>
