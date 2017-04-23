<div class="xmovement-propose-tile" data-design-task="{{ json_encode($design_task) }}">

	<div class="tile-body">

	    <span class="vertically-aligned-text">

	    	<h4>{{ str_limit($design_task['name'], 50) }}</h4>

	    </span>

	</div>

	<div class="tile-footer">

		<p class="add-text">
			{{ trans('proposals.add_to_proposal') }}
		</p>

		<p class="remove-text">
			{{ trans('proposals.remove_from_proposal') }}
		</p>

	</div>

</div>
