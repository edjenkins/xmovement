@extends('layouts.app', ['bodyclasses' => 'grey'])

@section('content')

	<div class="page-header">

        <h2 class="main-title">{{ $idea->name }}</h2>
		<h5 class="sub-title">{{ trans('idea.organized_by', ['user_name' => $idea->user->name]) }}</h5>

	</div>

	<div class="container">

	    <div class="row">
	    	<div class="col-md-3 col-md-push-9 hidden-sm hidden-xs">

	    		<div class="column side-column">

					@include('ideas/side-column')

	    		</div>

    		</div>
	    	<div class="col-md-9 col-md-pull-3">

	    		<div class="column main-column">

					<div class="idea-section">

		    			<div class="idea-media" style="background-image: url('{{ ResourceImage::getImage($idea->photo, 'large') }}')"></div>

						@include('ideas/progress')

						@if($idea->design_state == 'open')
							@include('ideas/notification', ['message' => trans('idea.design_phase_open_notification'), 'notification_type' => 'design-phase-notification'])
						@elseif($idea->proposal_state == 'open')
							@include('ideas/notification', ['message' => trans('idea.proposal_phase_open_notification'), 'notification_type' => 'proposal-phase-notification'])
						@endif

		    			<p class="idea-description">
		    				{{ $idea->description }}
		    			</p>

					</div>

	    			<div class="mobile-sidebar side-column hidden-md hidden-lg">

    					@include('ideas/side-column')

    				</div>

					@unless($idea->proposal_state == 'closed')

						<div class="proposals-container hidden-xs">

			    			<div class="section-header">
								<h2>{{ trans('idea.proposals') }}</h2>
								<a href="{{ action('ProposeController@index', $idea) }}">{{ trans('idea.view_all_proposals') }}</a>
							</div>

							<div class="proposals-wrapper">

								@if (count($idea->proposals) > 0)

									@foreach ($idea->proposals->take(3) as $index => $proposal)
										<div class="col-xs-12 col-sm-6 col-md-4">
											@include('propose/tile', ['proposal' => $proposal, 'index' => $index])
										</div>
									@endforeach

									<div class="clearfloat"></div>

								@else

									<div class="idea-section padded first-to-add">
										@can('add_proposal', $idea)
											<a href="{{ action('ProposeController@add', $idea) }}">
												{{ trans('idea.first_to_add_proposal') }}
											</a>
										@else
											<a href="{{ action('ProposeController@index', $idea) }}">
												{{ trans('idea.no_proposals_added_yet') }}
											</a>
										@endcan
									</div>

								@endif

							</div>

						</div>

					@endunless

					@unless($idea->design_state == 'closed')

						<div class="design-tasks-container hidden-xs">

			    			<div class="section-header">
								<h2>{{ trans('idea.design_tasks') }}</h2>
								<a href="{{ action('DesignController@dashboard', $idea) }}">{{ trans('idea.view_all_design_tasks') }}</a>
							</div>

							<div class="design-tasks-wrapper">

								@if (count($idea->featuredDesignTasks) > 0)

									@foreach ($idea->featuredDesignTasks as $design_task)

										{!! $design_task->xmovement_task->renderTile($design_task) !!}

									@endforeach

									<div class="clearfloat"></div>

								@else

									<div class="idea-section padded first-to-add">
										@can('contribute', $idea)
											<a href="{{ action('DesignController@add', $idea) }}">
												{{ trans('idea.first_to_add_design_task') }}
											</a>
										@else
											<a href="{{ action('DesignController@dashboard', $idea) }}">
												{{ trans('idea.no_design_tasks_added_yet') }}
											</a>
										@endcan
									</div>

								@endif

								<div class="clearfloat"></div>

							</div>

						</div>

					@endunless

					@unless((count($updates) == 0) && (Gate::denies('postUpdate', $idea)))

						<div class="section-header">
							<h2>{{ trans('idea.updates') }}</h2>
						</div>

						<div class="idea-section updates-section">

			    			@include('ideas/updates', ['updates' => $updates])

						</div>

					@endunless

					<div class="section-header">
						<h2>{{ trans('idea.discussion') }}</h2>
					</div>

					<div class="idea-section comments-section">

						@include('discussion')

					</div>

	    		</div>

	    	</div>
	    </div>
	</div>

	@can('support', $idea)

		@include('modals/support')

	@endcan

	@can('open_design_phase', $idea)

		@include('modals/open-design-phase', ['idea' => $idea])

	@endcan

	<?php Session::set('redirect', Request::url()); ?>

	<script type="text/javascript">

		var idea_id = '{{ $idea->id }}';
		var idea_name = '{{ $idea->name }}';
		var idea_url = '{{ url()->current() }}';
		var auth_type = '{{ Session::pull("auth_type") }}';
		var is_authorized = '{{ Auth::check() ? true : false }}';
		var show_support = '{{ Session::pull("show_support") ? true : false }}';

	</script>

	<script src="/js/ideas/view.js"></script>
	<script src="/js/ideas/update.js"></script>

@endsection
