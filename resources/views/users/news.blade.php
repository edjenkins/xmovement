@if(true)

	<div class="no-content no-messages">
		<h3>
			@if($viewing_own_profile)
				{{ trans('profile.no_news_on_own_profile') }}
			@else
				{{ trans('profile.no_news_on_other_profile') }}
			@endif
		</h3>
	</div>

@else

	<ul class="news-feed">

		<li></li>
		<li></li>
		<li></li>

	</ul>

@endif
