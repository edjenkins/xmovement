<?php $proposal_mode = (isset($proposal_mode)) ? $proposal_mode : false; ?>

<li class="proposal-item">

	<a href="{{ action('UserController@profile', $schedulerOption->user) }}" title="{{ $schedulerOption->user['name'] }}" class="scheduler-option-user" style="background-image: url('/uploads/images/small/{{ $schedulerOption->user['avatar'] }}/{{ urlencode($schedulerOption->user['name']) }}')"></a>

	<div class="scheduler-option-value">
		<h5>{{ $schedulerOption->getDate() }} - {{ $schedulerOption->getTime() }}</h5>
		<p class="author-subtitle"> by <a href="{{ action('UserController@profile', $schedulerOption['user']) }}">{{ $schedulerOption['user']['name'] }}</a></p>
	</div>

	<div class="vote-container scheduler-option-vote-container {{ ($schedulerOption->voteCount() == 0) ? '' : (($schedulerOption->voteCount() > 0) ? 'positive-vote' : 'negative-vote') }}">

		<div class="vote-controls">
			@can('contribute', $design_task)
				@unless ($proposal_mode)
					<div class="vote-button vote-up {{ ($schedulerOption->userVote() > 0) ? 'voted' : '' }}" data-vote-direction="up" data-votable-type="scheduler" data-votable-id="{{ $schedulerOption['id'] }}" title="Vote up">
						<i class="fa fa-2x fa-angle-up"></i>
					</div>
				@endunless
			@endcan
			@cannot('contribute', $design_task)
				<div class="voting-locked">
					<i class="fa fa-lock"></i>
				</div>
			@endcannot
			<div class="vote-count">
				{{ $schedulerOption->voteCount() }}
			</div>
			@can('contribute', $design_task)
				@unless ($proposal_mode)
					<div class="vote-button vote-down {{ ($schedulerOption->userVote() < 0) ? 'voted' : '' }}" data-vote-direction="down" data-votable-type="scheduler" data-votable-id="{{ $schedulerOption['id'] }}" title="Vote down">
						<i class="fa fa-2x fa-angle-down"></i>
					</div>
				@endunless
			@endcan
			@if ($proposal_mode)

				@if (array_key_exists($design_task->id, $contributions))
					@if (in_array($schedulerOption->id, $contributions[$design_task->id]))
						<i class="fa fa-check-square fa-2x proposal-button" data-contribution-id="{{ $schedulerOption->id }}"></i>
					@else
						<i class="fa fa-square fa-2x proposal-button" data-contribution-id="{{ $schedulerOption->id }}"></i>
					@endif
				@else
					<i class="fa fa-square fa-2x proposal-button" data-contribution-id="{{ $schedulerOption->id }}"></i>
				@endif

			@endif
		</div>

	</div>

</li>
