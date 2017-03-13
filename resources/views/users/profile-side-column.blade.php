<div class="col-sm-5 col-md-4 col-lg-3 profile-side-column">

	<div class="avatar-wrapper">
		<div class="avatar" style="background-image: url('{{ ResourceImage::getProfileImage($user, 'small') }}')"></div>
	</div>

	<h2 class="user-name visible-xs-block">
		{{ $user->name }}
	</h2>

	@if ($viewing_own_profile)
		@if (false)
			<form action="{{ action('MessagesController@sendQuote') }}" method="POST">
				{!! csrf_field() !!}

				<button type="submit" class="contact-button">
					{{ trans('profile.send_a_quote') }}
				</button>

			</form>
		@endif
	@else
		<div class="contact-button" data-toggle="modal" data-target="#direct-message-modal">
			{{ trans('profile.send_a_message') }}
		</div>
	@endif

	@unless (count($created_ideas) == 0)

		<div class="sidebar-section hidden-xs">
			<div class="sidebar-section-header">
				{{ trans('profile.created_ideas') }}
			</div>
			<ul class="ideas-list">
				@foreach ($created_ideas as $idea)
	                @include('ideas.mini-tile')
	            @endforeach
			</ul>
		</div>

	@endunless

	@unless (count($supported_ideas) == 0)

		<div class="sidebar-section hidden-xs">
			<div class="sidebar-section-header">
				{{ trans('profile.supported_ideas') }}
			</div>
			<ul class="ideas-list">
				@foreach ($supported_ideas as $idea)
	                @include('ideas.mini-tile')
	            @endforeach
			</ul>
		</div>

	@endunless

</div>
