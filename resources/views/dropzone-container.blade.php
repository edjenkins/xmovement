<div class="dropzone-container">

	<div class="dropzone dropzone-{{ $dropzone_id }}" id="dropzone">
		{!! csrf_field() !!}
		<input type="hidden" name="type" value="{{ $type }}">
		<div class="dz-message" data-dz-message><span>{{ trans('dropzone.drop_files_here_to_upload') }}</span></div>
	</div>

</div>
