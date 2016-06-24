<?php $proposal_mode = (isset($proposal_mode)) ? $proposal_mode : false; ?>

<li class="contribution-submission-item" data-contribution-type-id="{{ $contributionSubmission->contributionAvailableType->id }}">

	<a href="{{ action('UserController@profile', $contributionSubmission->user) }}" title="{{ $contributionSubmission->user['name'] }}" class="contribution-submission-user" style="background-image: url('/uploads/images/small/{{ $contributionSubmission->user['avatar'] }}/{{ urlencode($contributionSubmission->user['name']) }}')"></a>

	<div class="contribution-submission-value">

		<?php $value = json_decode($contributionSubmission['value']); ?>

		<?php if ($contributionSubmission->contributionAvailableType->id == '1') { ?>

			<h5>{{ $value->text }}</h5>
			<p class="author-subtitle"> by <a href="{{ action('UserController@profile', $contributionSubmission['user']) }}">{{ $contributionSubmission['user']['name'] }}</a></p>

		<?php } ?>

		<?php if ($contributionSubmission->contributionAvailableType->id == '2') { ?>


			<h5>{{ $value->description }}</h5>
			<p class="author-subtitle"> by <a href="{{ action('UserController@profile', $contributionSubmission['user']) }}">{{ $contributionSubmission['user']['name'] }}</a></p>

			<a href="/uploads/images/large/{{ $value->image }}" target="_blank">
				<img src="/uploads/images/small/{{ $value->image }}"/>
			</a>

		<?php } ?>

		<?php if ($contributionSubmission->contributionAvailableType->id == '3') { ?>


			<h5>{{ $value->description }}</h5>
			<p class="author-subtitle"> by <a href="{{ action('UserController@profile', $contributionSubmission['user']) }}">{{ $contributionSubmission['user']['name'] }}</a></p>

			<div class="video-wrapper">
				<div class="video-container">
					<iframe src="{{ $value->video }}" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen width="560" height="315"></iframe>
				</div>
			</div>

		<?php } ?>

		<?php if ($contributionSubmission->contributionAvailableType->id == '4') { ?>

			<div class="item-description">
				{{ $value->description }}
			</div>

			<div class="file-container">
				<div class="file-icon">
					<?php
					$extension = pathinfo($value->file, PATHINFO_EXTENSION);
					switch ($extension) {
						case 'pdf':
							$class = 'fa-file-pdf-o';
							break;
						case 'doc':
							$class = 'fa-file-word-o';
							break;
						case 'docx':
							$class = 'fa-file-word-o';
							break;
						case 'txt':
							$class = 'fa-file-text-o';
							break;
						case 'rtf':
							$class = 'fa-file-text-o';
							break;
						case 'zip':
							$class = 'fa-file-archive-o';
							break;

						default:
							$class = 'fa-file-o';
							break;
					}
					?>
					<i class="fa {{ $class }}" aria-hidden="true"></i>
				</div>
				<div class="file-name">
					<a href="https://s3.amazonaws.com/xmovement/uploads/files/{{ $value->file }}" target="_blank">{{ $value->file }}</a>
				</div>
			</div>

		<?php } ?>

	</div>

	<div class="vote-container contribution-submission-vote-container {{ ($contributionSubmission->voteCount() == 0) ? '' : (($contributionSubmission->voteCount() > 0) ? 'positive-vote' : 'negative-vote') }}">

		<div class="vote-controls">
			@can('contribute', $design_task)
				@unless ($proposal_mode)
					<div class="vote-button vote-up {{ ($contributionSubmission->userVote() > 0) ? 'voted' : '' }}" data-vote-direction="up" data-votable-type="contribution" data-votable-id="{{ $contributionSubmission['id'] }}" title="Vote up">
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
				{{ $contributionSubmission->voteCount() }}
			</div>
			@can('contribute', $design_task)
				@unless ($proposal_mode)
					<div class="vote-button vote-down {{ ($contributionSubmission->userVote() < 0) ? 'voted' : '' }}" data-vote-direction="down" data-votable-type="contribution" data-votable-id="{{ $contributionSubmission['id'] }}" title="Vote down">
						<i class="fa fa-2x fa-angle-down"></i>
					</div>
				@endunless
			@endcan
			@if ($proposal_mode)

				@if (array_key_exists($design_task->id, $contributions))
					@if (in_array($contributionSubmission->id, $contributions[$design_task->id]))
						<i class="fa fa-check-square fa-2x proposal-button" data-contribution-id="{{ $contributionSubmission->id }}"></i>
					@else
						<i class="fa fa-square fa-2x proposal-button" data-contribution-id="{{ $contributionSubmission->id }}"></i>
					@endif
				@else
					<i class="fa fa-square fa-2x proposal-button" data-contribution-id="{{ $contributionSubmission->id }}"></i>
				@endif

			@endif
		</div>

	</div>

</li>
