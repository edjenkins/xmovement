<div class="tile proposal-tile">

	<div class="avatar-wrapper">
		<div class="avatar" style="background-image: url('{{ ResourceImage::getProfileImage($proposal->user, 'small') }}')"></div>
	</div>

	<div class="tile-body">

		<h5 class="proposal-description">
			{{ str_limit($proposal->description, $limit = 80, $end = '...') }}
		</h5>

		<p>
			@if($idea->proposal_state == 'locked' && $index == 0)
				<div class="winner-banner">{{ trans('proposals.winner') }}</div>
			@else
				{{ trans('proposals.added_x_ago', ['time' => $proposal->created_at->diffForHumans()]) }}
			@endif
		</p>
		<p>
			{{ trans('proposals.posted_by_x', ['url' => action('UserController@profile', [$proposal->user]), 'name' => $proposal->user->name]) }}
		</p>

	</div>

	<div class="tile-footer">

		<a href="{{ action('ProposeController@view', $proposal->id) }}">
			{{ trans('proposals.view_proposal') }}
		</a>

	</div>

</div>
