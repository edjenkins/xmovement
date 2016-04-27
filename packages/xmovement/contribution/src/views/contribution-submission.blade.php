<style type="text/css">
	
	.video-wrapper {
		max-width: 400px;	
	}

	.video-container {
		margin: 20px auto;
		position: relative;
		padding-bottom: 56.25%;
		padding-top: 30px; height: 0; overflow: hidden;
	}

	.video-container iframe,
	.video-container object,
	.video-container embed {
		position: absolute;
		top: 0;
		left: 0;
		width: 100%;
		height: 100%;
	}

</style>

<li>
	
	<a href="{{ action('UserController@profile', $contributionSubmission->user) }}" title="{{ $contributionSubmission->user['name'] }}" class="contribution-submission-user" style="background-image: url('{{ $contributionSubmission->user['avatar'] }}')"></a>	

	<div class="contribution-submission-value">

		<?php if ($contributionSubmission->contributionAvailableType->id == '1') { ?>

			{{ $contributionSubmission['value'] }}
			
		<?php } ?>

		<?php if ($contributionSubmission->contributionAvailableType->id == '2') { ?>

			<img src="{{ $contributionSubmission['value'] }}" height="100" style="margin: 15px 0" />
			
		<?php } ?>

		<?php if ($contributionSubmission->contributionAvailableType->id == '3') { ?>

			<div class="video-wrapper">
				<div class="video-container">
					<iframe src="{{ $contributionSubmission['value'] }}" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen width="560" height="315"></iframe>
				</div>
			</div>
			
		<?php } ?>

		<?php if ($contributionSubmission->contributionAvailableType->id == '4') { ?>

			<p>Some file</p>
			
		<?php } ?>

	</div>

	<div class="vote-container contribution-submission-vote-container {{ ($contributionSubmission->voteCount() == 0) ? '' : (($contributionSubmission->voteCount() > 0) ? 'positive-vote' : 'negative-vote') }}">
		<div class="vote-controls">
			<div class="vote-button vote-up {{ ($contributionSubmission->userVote() > 0) ? 'voted' : '' }}" data-vote-direction="up" data-votable-type="contribution" data-votable-id="{{ $contributionSubmission['id'] }}" title="Vote up">
				<i class="fa fa-2x fa-angle-up"></i>
			</div>
			<div class="vote-count">
				{{ $contributionSubmission->voteCount() }}
			</div>
			<div class="vote-button vote-down {{ ($contributionSubmission->userVote() < 0) ? 'voted' : '' }}" data-vote-direction="down" data-votable-type="contribution" data-votable-id="{{ $contributionSubmission['id'] }}" title="Vote down">
				<i class="fa fa-2x fa-angle-down"></i>
			</div>
		</div>
	</div>

</li>