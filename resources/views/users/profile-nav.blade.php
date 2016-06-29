<div class="profile-nav">
	<ul>

		@can('editPreferences', $user)

			<li class="{{ $viewing_own_profile ? 'active' : '' }}"><a href="#preferencestab" data-toggle="tab">Preferences</a></li>

		@endcan

		@can('viewNews', $user)

			<li class="{{ $viewing_own_profile ? '' : 'active' }}"><a href="#newstab" data-toggle="tab">News</a></li>

		@endcan

		@can('viewMessages', $user)

			<li><a href="#messagestab" data-toggle="tab">Messages</a></li>

		@endcan

	</ul>
</div>
