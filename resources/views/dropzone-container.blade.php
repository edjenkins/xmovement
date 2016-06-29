<div class="dropzone-container">

	<div class="dropzone dropzone-{{ $dropzone_id }}" id="dropzone">
		{!! csrf_field() !!}
		<input type="hidden" name="type" value="{{ $type }}">
	</div>

</div>
