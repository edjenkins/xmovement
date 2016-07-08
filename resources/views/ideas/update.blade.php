<li class="update" id="update-{{ $update->id }}">
	<h5>
		<i class="fa fa-star"></i>
		Update posted {{ $update->created_at->diffForHumans() }}
	</h5>

	<p>
		{!! nl2br($update->text) !!}
	</p>

	@can('destroyUpdate', $update->idea)

		<i class="fa fa-trash-o destroy-update-button" data-update-id="{{ $update->id }}" data-delete-confirmation="{{ trans('idea.update_delete_confirmation') }}"></i>

	@endcan
</li>
