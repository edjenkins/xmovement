@unless($idea->design_state == 'closed')

	<div class="design-tasks-container hidden-xs">

		<div class="section-header">
			<h2>{{ trans('idea.design_tasks') }}</h2>
			<a target="_self" href="{{ action('DesignController@dashboard', $idea) }}">{{ trans('idea.view_all_design_tasks') }}</a>
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
						<a target="_self" href="{{ action('DesignController@add', $idea) }}">
							{{ trans('idea.first_to_add_design_task') }}
						</a>
					@else
						<a target="_self" href="{{ action('DesignController@dashboard', $idea) }}">
							{{ trans('idea.no_design_tasks_added_yet') }}
						</a>
					@endcan
				</div>

			@endif

			<div class="clearfloat"></div>

		</div>

	</div>

@endunless
