<div class="profile-nav">
	<ul>
		
		@can('viewNews', $user)

			<li class="active"><a href="#newstab" data-toggle="tab">News</a></li>

		@endcan

		@can('viewMessages', $user)
			
			<li><a href="#messagestab" data-toggle="tab">Messages</a></li>

		@endcan

		@can('editPreferences', $user)

			<li><a href="#preferencestab" data-toggle="tab">Preferences</a></li>

		@endcan

	</ul>
</div>