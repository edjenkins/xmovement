<div class="xmovement-tile">

    <a href="/design/contribution/{{ $design_task['id'] }}">
    	<div class="tile-body">

		    <span class="vertically-aligned-text">

		    	<h4>{{ str_limit($design_task['name'], 50) }}</h4>

		    	<p>
					<i class="fa fa-lightbulb-o"></i>
		    		{{ $contribution->contributionSubmissions->count() }}
		    	</p>

		    </span>

		</div>

	</a>

	@include('xmovement/shared/tile/footer', ['design_task' => $design_task])

</div>
