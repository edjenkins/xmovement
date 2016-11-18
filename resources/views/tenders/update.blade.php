<div class="timeline-section">

	<div class="tender-update update" id="update-{{ $update->id }}">

		<div class="update-label">
			<!-- 23 September '17 -->
			{{ trans('idea.updated_posted_x', ['time' => $update->created_at->diffForHumans()]) }}
		</div>

		<h5>
			Example Title
		</h5>

		<p>
			{!! nl2br($update->text) !!}
		</p>

		@can('destroyUpdate', $update)

			<i class="fa fa-trash-o destroy-update-button" data-update-id="{{ $update->id }}" data-delete-confirmation="{{ trans('idea.update_delete_confirmation') }}"></i>

		@endcan

	</div>

</div>
