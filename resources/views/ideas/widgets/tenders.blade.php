@unless($idea->tender_state == 'closed')

	<div class="tenders-container hidden-xs">

		<div class="section-header">
			<h2>{{ trans('idea.tenders') }}</h2>
			<a href="{{ action('TenderController@index', $idea) }}">{{ trans('idea.view_all_tenders') }}</a>
		</div>

		<div class="tenders-wrapper">

			@if (count($idea->tenders) > 0)

				@foreach ($idea->tenders->take(2) as $index => $tender)
					<div class="col-xs-12 col-md-6">
						@include('tenders/tile', ['tender' => $tender, 'index' => $index])
					</div>
				@endforeach

				<div class="clearfloat"></div>

			@else

				<div class="idea-section padded first-to-add">
					@can('add_tender', $idea)
						<a href="{{ action('TenderController@add', $idea) }}">
							{{ trans('idea.first_to_add_tender') }}
						</a>
					@else
						<a href="{{ action('TenderController@index', $idea) }}">
							{{ trans('idea.no_tenders_added_yet') }}
						</a>
					@endcan
				</div>

			@endif

		</div>

	</div>

@endunless
