<?php $proposal_mode = (isset($proposal_mode)) ? $proposal_mode : false; ?>

<li class="proposal-item">

	<a target="_self" href="{{ action('UserController@profile', $pollOption->user) }}" title="{{ $pollOption->user['name'] }}" class="poll-option-user" style="background-image: url('{{ ResourceImage::getProfileImage($pollOption->user, 'small') }}')"></a>

	<div class="poll-option-value">
		<h5>{{ $pollOption['value'] }}</h5>
		<p class="author-subtitle"> by <a target="_self" href="{{ action('UserController@profile', $pollOption['user']) }}">{{ $pollOption['user']['name'] }}</a></p>
	</div>

	<div class="vote-container poll-option-vote-container {{ ($pollOption->voteCount() == 0) ? '' : (($pollOption->voteCount() > 0) ? 'positive-vote' : 'negative-vote') }}">

		<div class="vote-controls">
			@can('vote_on_design_submissions', $design_task)
				@unless ($proposal_mode)
					<div class="vote-button vote-up {{ ($pollOption->userVote() > 0) ? 'voted' : '' }}" data-vote-direction="up" data-votable-type="poll" data-votable-id="{{ $pollOption['id'] }}" title="Vote up">
						<i class="fa fa-lg fa-thumbs-up"></i>
					</div>
				@endunless
			@endcan
			@cannot('vote_on_design_submissions', $design_task)
				<div class="voting-locked">
					<i class="fa fa-lock"></i>
				</div>
			@endcannot
			<div class="vote-count">
				{{ $pollOption->voteCount() }}
			</div>
			@can('vote_on_design_submissions', $design_task)
				@unless ($proposal_mode)
					<div class="vote-button vote-down {{ ($pollOption->userVote() < 0) ? 'voted' : '' }}" data-vote-direction="down" data-votable-type="poll" data-votable-id="{{ $pollOption['id'] }}" title="Vote down">
						<i class="fa fa-lg fa-thumbs-down"></i>
					</div>
				@endunless
			@endcan
			@if ($proposal_mode)

				@if (array_key_exists($design_task->id, $contributions))
					@if (in_array($pollOption->id, $contributions[$design_task]))
						<i class="fa fa-check-square fa-2x proposal-button" data-contribution-id="{{ $pollOption->id }}"></i>
					@else
						<i class="fa fa-square fa-2x proposal-button" data-contribution-id="{{ $pollOption->id }}"></i>
					@endif
				@else
					<i class="fa fa-square fa-2x proposal-button" data-contribution-id="{{ $pollOption->id }}"></i>
				@endif

			@endif
		</div>

	</div>

</li>
