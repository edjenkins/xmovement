<div class="creator-tile" onClick="document.location = '{{ action('UserController@profile', $idea->user_id) }}';">
	<div class="creator-avatar" style="background-image:url('https://s3.amazonaws.com/xmovement/uploads/images/medium/{{ $idea->user->avatar }}?name={{ urlencode($idea->user->name) }}')"></div>
	<h4>{{ $idea->user->name }}</h4>
	<h5 class="subtitle">Idea Creator</h5>
</div>

<div class="stats-tile supporters-tile">
	<h3 class="supporter-count">{{ $idea->supporterCount() }}</h3>
	<h5 class="supporter-subtitle">{{ trans_choice('idea.supporters', $idea->supporterCount()) }}</h5>
	<div class="stats-tile-footer supporters-tile-footer{{ $supported ? ' visible' : '' }}">{{ trans('common.you_supported_idea') }}</div>
</div>

<ul class="sidebar-social-links">
	<li class="share-fb"><i class="fa fa-facebook"></i></li>
	<li class="share-twitter"><i class="fa fa-twitter"></i></li>
	<li class="share-googleplus"><i class="fa fa-google-plus"></i></li>
	<li class="share-email"><i class="fa fa-envelope"></i></li>
</ul>

@include('action-button')

@if ($idea->design_state == 'closed')

	<div class="info-tile">
		<div class="info-tile-content">
			<p>
				<i class="fa fa-info"></i>
				Design area opens in {{ $idea->designPhaseOpens() }}
			</p>
		</div>
	</div>

@endif

@if ($idea->proposal_state == 'closed')

	<div class="info-tile">
		<div class="info-tile-content">
			<p>
				<i class="fa fa-info"></i>
				Proposal area opens in {{ $idea->proposalPhaseOpens() }}
			</p>
		</div>
	</div>

@endif