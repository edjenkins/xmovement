<div class="tile tender-tile">

	<div class="upper-section">

		<div class="avatar-wrapper">
			<div class="avatar" style="background-image: url('{{ ResourceImage::getImage($tender->team->avatar, 'large') }}')"></div>
		</div>

		<div class="tile-body">

			<h5 class="tender-company">
				{{ str_limit($tender->team->name, $limit = 80, $end = '...') }}
			</h5>

			<p>
				{{ count($tender->team->users) }} Members
			</p>

		</div>

	</div>

	<div class="lower-section">

		<div class="tender-summary">
			{{ str_limit($tender->team->bio, $limit = 260, $end = '...') }}
		</div>

	</div>

	<div class="tile-footer">

		<ul>
			<li>
				<i class="fa fa-star"></i>
				{{ count($tender->updates) }} Updates
			</li>
			<li>
				<a target="_self" href="{{ action('TenderController@view', $tender) }}">View Tender</a>
			</li>
		</ul>

	</div>

</div>
