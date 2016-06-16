<?php $proposal_mode = (isset($proposal_mode)) ? $proposal_mode : false; ?>

<li class="proposal-item">

	<a href="{{ action('UserController@profile', $schedulerOption->user) }}" title="{{ $schedulerOption->user['name'] }}" class="scheduler-option-user" style="background-image: url('/uploads/images/small/{{ $schedulerOption->user['avatar'] }}')"></a>

	<div class="scheduler-option-value">
		<h2>{{ $schedulerOption->getTime() }}</h2>
		<h3>{{ $schedulerOption->getDate() }}</h3>
	</div>

	<div class="vote-container scheduler-option-vote-container {{ ($schedulerOption->voteCount() == 0) ? '' : (($schedulerOption->voteCount() > 0) ? 'positive-vote' : 'negative-vote') }}">

		<div class="vote-controls">
			@unless ($proposal_mode)
				<div class="vote-button vote-up {{ ($schedulerOption->userVote() > 0) ? 'voted' : '' }}" data-vote-direction="up" data-votable-type="scheduler" data-votable-id="{{ $schedulerOption['id'] }}" title="Vote up">
					<i class="fa fa-2x fa-angle-up"></i>
				</div>
			@endunless
			<div class="vote-count">
				{{ $schedulerOption->voteCount() }}
			</div>
			@unless ($proposal_mode)
				<div class="vote-button vote-down {{ ($schedulerOption->userVote() < 0) ? 'voted' : '' }}" data-vote-direction="down" data-votable-type="scheduler" data-votable-id="{{ $schedulerOption['id'] }}" title="Vote down">
					<i class="fa fa-2x fa-angle-down"></i>
				</div>
			@endunless
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
