<li>

	<a href="{{ action('UserController@profile', $pollOption->user) }}" title="{{ $pollOption->user['name'] }}" class="poll-option-user" style="background-image: url('{{ $pollOption->user['avatar'] }}/{{ urlencode($pollOption->user['name']) }}')"></a>	

	<div class="poll-option-value">{{ $pollOption['value'] }}</div>

	<div class="vote-container poll-option-vote-container {{ ($pollOption->voteCount() == 0) ? '' : (($pollOption->voteCount() > 0) ? 'positive-vote' : 'negative-vote') }}">
		<div class="vote-controls">
			<div class="vote-button vote-up {{ ($pollOption->userVote() > 0) ? 'voted' : '' }}" data-vote-direction="up" data-votable-type="poll" data-votable-id="{{ $pollOption['id'] }}" title="Vote up">
				<i class="fa fa-2x fa-angle-up"></i>
			</div>
			<div class="vote-count">
				{{ $pollOption->voteCount() }}
			</div>
			<div class="vote-button vote-down {{ ($pollOption->userVote() < 0) ? 'voted' : '' }}" data-vote-direction="down" data-votable-type="poll" data-votable-id="{{ $pollOption['id'] }}" title="Vote down">
				<i class="fa fa-2x fa-angle-down"></i>
			</div>
		</div>
	</div>

</li>
