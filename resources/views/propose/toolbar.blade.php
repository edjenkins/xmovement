<div class="proposal-toolbar colorful">

	<ul class="page-dots">
		@foreach($proposal_tasks as $index => $proposal_task)
			@if ($proposal_task->proposal_interactivity)
				<li>
					<i class="fa {{ ($proposal_task_index == $index) ? 'fa-circle' : 'fa-circle-o' }}"></i>
				</li>
			@endif
		@endforeach
	</ul>

	<form action="{{ action('ProposeController@previous') }}" method="POST">
		{!! csrf_field() !!}
		<input type="hidden" name="current_task" value="{{ $design_task->id }}">
		<button class="previous-button pull-left" type="submit">
			<i class="fa fa-angle-left"></i>
		</button>
	</form>

	<form action="{{ action('ProposeController@next') }}" method="POST">
		{!! csrf_field() !!}
		<input type="hidden" name="current_task" value="{{ $design_task->id }}">
		<input type="hidden" name="selected_contributions" id="selected_contributions" data-original-values="{{ array_key_exists($design_task->id, $contributions) ? ltrim(implode(',', array_slice($contributions[$design_task->id], 0, count($contributions[$design_task->id]))),',') : '' }}" value="">
		<button class="next-button pull-right" type="submit">
			<i class="fa fa-angle-right"></i>
		</button>
	</form>

	<div class="clearfloat"></div>

</div>
