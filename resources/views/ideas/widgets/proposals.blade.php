@unless($idea->proposal_state == 'closed')

	<div class="proposals-container hidden-xs">

		<div class="section-header">
			<h2>{{ trans('idea.proposals') }}</h2>
			<a target="_self" href="{{ action('ProposalController@index', $idea) }}">{{ trans('idea.view_all_proposals') }}</a>
		</div>

		<div class="proposals-wrapper">

			@if (count($idea->proposals) > 0)

				@foreach ($idea->proposals->take(3) as $index => $proposal)
					<div class="col-xs-12 col-sm-6 col-md-4">
						@include('proposal/tile', ['proposal' => $proposal, 'index' => $index])
					</div>
				@endforeach

				<div class="clearfloat"></div>

			@else

				<div class="idea-section padded first-to-add">
					@can('add_proposal', $idea)
						<a target="_self" href="{{ action('ProposalController@add', $idea) }}">
							{{ trans('idea.first_to_add_proposal') }}
						</a>
					@else
						<a target="_self" href="{{ action('ProposalController@index', $idea) }}">
							{{ trans('idea.no_proposals_added_yet') }}
						</a>
					@endcan
				</div>

			@endif

		</div>

	</div>

@endunless
