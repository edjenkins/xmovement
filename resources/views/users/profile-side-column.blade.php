<div class="col-sm-5 col-md-4 col-lg-3 profile-side-column">

	<div class="avatar-wrapper">
		<div class="avatar" style="background-image: url('/uploads/images/small/{{ $user->avatar }}/{{ urlencode($user->name) }}')"></div>
	</div>

	<h2 class="user-name visible-xs-block">{{ $user->name }}</h2>

	<div class="contact-button">
		{{ trans('profile.send_a_message') }}
	</div>

	<div class="user-stats visible-md-block visible-lg-block">
		<h3></h3>
		<p></p>
	</div>

	<div class="sidebar-section hidden-xs">
		<div class="sidebar-section-header">
			{{ trans('profile.supported_ideas') }}
		</div>
		<ul class="ideas-list">
			@if (count($supported_ideas) > 0)
				@foreach ($supported_ideas as $idea)
	                @include('ideas.mini-tile')
	            @endforeach
			@else
			    <li>{{ trans('profile.no_ideas') }}</li>
			@endif
		</ul>
	</div>

	<div class="sidebar-section hidden-xs">
		<div class="sidebar-section-header">
			{{ trans('profile.created_ideas') }}
		</div>
		<ul class="ideas-list">
			@if (count($created_ideas) > 0)
			    @foreach ($created_ideas as $idea)
	                @include('ideas.mini-tile')
	            @endforeach
			@else
			    <li>{{ trans('profile.no_ideas') }}</li>
			@endif
		</ul>
	</div>

</div>
