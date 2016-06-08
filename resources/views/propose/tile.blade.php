<div class="tile proposal-tile">

    <a href="{{ action('ProposeController@view', $proposal->id) }}">

		<div class="avatar-wrapper">
			<div class="avatar" style="background-image: url('/uploads/images/small/{{ $proposal->user->avatar }}')"></div>
		</div>

    	<div class="tile-body">

			<p>
				Description - {{ $proposal->description }}
			</p>
			<p>
				Added {{ $proposal->created_at->diffForHumans() }}
			</p>
			<p>
				Posted by <a href="{{ action('UserController@profile', [$proposal->user]) }}">{{ $proposal->user->name or $proposal->user_id }}</a>
			</p>

		</div>

	</a>

	<div class="tile-footer">

		<div class="vote-container proposal-vote-container {{ ($proposal->voteCount() == 0) ? '' : (($proposal->voteCount() > 0) ? 'positive-vote' : 'negative-vote') }}">
			<div class="vote-controls">
				<div class="vote-button vote-up {{ ($proposal->userVote() > 0) ? 'voted' : '' }}" data-vote-direction="up" data-votable-type="proposal" data-votable-id="{{ $proposal['id'] }}">
					<i class="fa fa-2x fa-angle-up"></i>
				</div>
				<div class="vote-count">
					{{ $proposal->voteCount() }}
				</div>
				<div class="vote-button vote-down {{ ($proposal->userVote() < 0) ? 'voted' : '' }}" data-vote-direction="down" data-votable-type="proposal" data-votable-id="{{ $proposal['id'] }}">
					<i class="fa fa-2x fa-angle-down"></i>
				</div>
			</div>
		</div>

	</div>

</div>
