<li class="proposal-item">

	<a href="{{ action('UserController@profile', $pollOption->user) }}" title="{{ $pollOption->user['name'] }}" class="poll-option-user" style="background-image: url('/uploads/images/small/{{ $pollOption->user['avatar'] }}')"></a>

	<div class="poll-option-value">{{ $pollOption['value'] }}</div>

	<div class="vote-container poll-option-vote-container {{ ($pollOption->voteCount() == 0) ? '' : (($pollOption->voteCount() > 0) ? 'positive-vote' : 'negative-vote') }}">

		<div class="vote-controls">
			@unless ($proposal_mode)
				<div class="vote-button vote-up {{ ($pollOption->userVote() > 0) ? 'voted' : '' }}" data-vote-direction="up" data-votable-type="poll" data-votable-id="{{ $pollOption['id'] }}" title="Vote up">
					<i class="fa fa-2x fa-angle-up"></i>
				</div>
			@endunless
			<div class="vote-count">
				{{ $pollOption->voteCount() }}
			</div>
			@unless ($proposal_mode)
				<div class="vote-button vote-down {{ ($pollOption->userVote() < 0) ? 'voted' : '' }}" data-vote-direction="down" data-votable-type="poll" data-votable-id="{{ $pollOption['id'] }}" title="Vote down">
					<i class="fa fa-2x fa-angle-down"></i>
				</div>
			@endunless
			@if ($proposal_mode)
				<i class="fa fa-square fa-2x proposal-button" data-contribution-id="{{ $pollOption->id }}"></i>
			@endif
		</div>

	</div>

</li>
