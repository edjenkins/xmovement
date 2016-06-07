<div class="proposal-toolbar colorful">

	<ul class="page-dots">
		@foreach($proposal_tasks as $index => $proposal_task)
			<li class="{{ ($proposal_task_index < $index) ? '' : 'active' }}"></li>
		@endforeach
	</ul>

	<form action="{{ action('ProposeController@previous') }}" method="POST">
		{!! csrf_field() !!}
		<input type="hidden" name="current_task" value="{{ $design_task->id }}">
		<button class="previous-button pull-left" type="submit">
			<i class="fa fa-arrow-left fa-2x"></i>
		</button>
	</form>

	<form action="{{ action('ProposeController@next') }}" method="POST">
		{!! csrf_field() !!}
		<input type="hidden" name="current_task" value="{{ $design_task->id }}">
		<input type="hidden" name="selected_contributions" id="selected_contributions" value="">
		<button class="next-button pull-right" type="submit">
			<i class="fa fa-arrow-right fa-2x"></i>
		</button>
	</form>

	<div class="clearfloat"></div>

</div>
