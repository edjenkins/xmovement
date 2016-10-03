<div class="tile tender-tile">

	<div class="upper-section">

		<div class="avatar-wrapper">
			<div class="avatar" style="background-image: url('{{ ResourceImage::getProfileImage($tender->user, 'small') }}')"></div>
		</div>

		<div class="tile-body">

			<h5 class="tender-company">
				{{ str_limit($tender->company, $limit = 80, $end = '...') }}
			</h5>

			<p>
				{{ trans('tenders.posted_by_x', ['url' => action('UserController@profile', [$tender->user]), 'name' => $tender->user->name]) }}
			</p>

		</div>

	</div>

	<div class="lower-section">

		<div class="tender-summary">
			{{ str_limit($tender->summary, $limit = 260, $end = '...') }}
		</div>

	</div>

	<div class="tile-footer">

		<ul>
			<li>
				<i class="fa fa-star"></i>
				14 Updates
			</li>
			<li>
				<a href="{{ action('TenderController@view', $tender) }}">Open Tender</a>
			</li>
		</ul>

	</div>

</div>
