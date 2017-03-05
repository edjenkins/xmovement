<div class="modal fade" id="info-modal" tabindex="-1" role="dialog">

	<div class="modal-dialog" role="document">

		<div class="modal-content">

			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

				<h4 class="modal-title" id="info-modal">
					{!! $info_dialogue->title !!}
				</h4>

			</div>

			<div class="modal-body">

				<div id="info-modal-content">
					{!! $info_dialogue->content !!}
				</div>

			</div>

			<div class="modal-footer">

				<button type="button" class="btn btn-primary" data-dismiss="modal" aria-label="Close">{{ trans('common.continue') }}</button>

			</div>

		</div>

	</div>

</div>


<script type="text/javascript">

	// Show the modal automatically
	$(document).ready(function() { $('#info-modal').modal('show'); })

</script>
