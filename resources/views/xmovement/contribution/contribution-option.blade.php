<li>
	
	<a href="{{ action('UserController@profile', $contributionOption->user) }}" title="{{ $contributionOption->user['name'] }}" class="contribution-option-user" style="background-image: url('{{ $contributionOption->user['avatar'] }}')"></a>	

	<div class="contribution-option-value">{{ $contributionOption['value'] }}</div>

	<div class="vote-container contribution-option-vote-container {{ ($contributionOption->voteCount() == 0) ? '' : (($contributionOption->voteCount() > 0) ? 'positive-vote' : 'negative-vote') }}">
		<div class="vote-controls">
			<div class="vote-button vote-up {{ ($contributionOption->userVote() > 0) ? 'voted' : '' }}" data-vote-direction="up" data-votable-type="contribution" data-votable-id="{{ $contributionOption['id'] }}" title="Vote up">
				<i class="fa fa-2x fa-angle-up"></i>
			</div>
			<div class="vote-count">
				{{ $contributionOption->voteCount() }}
			</div>
			<div class="vote-button vote-down {{ ($contributionOption->userVote() < 0) ? 'voted' : '' }}" data-vote-direction="down" data-votable-type="contribution" data-votable-id="{{ $contributionOption['id'] }}" title="Vote down">
				<i class="fa fa-2x fa-angle-down"></i>
			</div>
		</div>
	</div>

</li>