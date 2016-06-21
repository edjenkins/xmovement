<?php $cc = (isset($cc)) ? $cc : false; ?>

<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/dropzone/dropzone.css') }}">

<input type="hidden" name="photo" id="{{ $input_id }}" value="{{ isset($value) ? $value : "" }}" />

@if ($cc)

	<!-- Nav tabs -->
	<ul class="nav nav-tabs" role="tablist">
	  <li role="presentation" class="active"><a href="#search" aria-controls="search" role="tab" data-toggle="tab">Search</a></li>
	  <li role="presentation"><a href="#upload" aria-controls="upload" role="tab" data-toggle="tab">Upload</a></li>
	</ul>

@endif

<!-- Tab panes -->
<div class="tab-content">

	@if ($cc)

		<div role="tabpanel" class="tab-pane active" id="search">

			@include('cc-container')

		</div>

	@endif

	<div role="tabpanel" class="tab-pane {{ ($cc) ? '' : 'active' }}" id="upload">

		@include('dropzone-container')

	</div>

</div>

<div class="current-file-preview <?php if (isset($value)) { echo 'visible'; } ?>">
	<div id="file-preview-thumbnail" <?php if (isset($value)) { echo 'style="background-image: url(https://s3.amazonaws.com/xmovement/uploads/images/small/' . $value . ')"'; } ?>></div>
	<p id="file-preview-filename">{{ $value or '' }}</p>
</div>

<script type="text/javascript" src="{{ URL::asset('js/vendor/dropzone.js') }}"></script>

<script type="text/javascript">

	var dropzone_uploaded_file;

	$(document).ready(function() {

		Dropzone.autoDiscover = false;

		var theDropzone = new Dropzone("#dropzone", { url: "/upload"});

		Dropzone.options.theDropzone = {
      uploadMultiple: false,
		  addRemoveLinks: true,
	    removedfile: function(file) {
	      var _ref;
	      return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
	    }
		};

		theDropzone.on("sending", function(file, response) {

			if ($('.dz-preview').length > 1) {
				$('.dz-preview').each(function(index, element) {
					if (index < $('.dz-preview').length)
					{
						$(element).remove();
					}
				})
			}

		})

    theDropzone.on("success", function(file, response) {
			dropzone_uploaded_file = response.filename;
			if ($('#{{ $input_id }}').length) {
					$('#{{ $input_id }}').val(response.filename);
					$('#file-preview-filename').html(response.filename);
					$('#file-preview-thumbnail').css('background-image','url(https://s3.amazonaws.com/xmovement/uploads/images/small/' + response.filename + ')');
					$('.current-file-preview').addClass('visible');
			}
    });

		theDropzone.on("sending", function(file, xhr, formData) {
		  formData.append("_token", $('input[name="_token"]').val());
			formData.append("type", $('input[name="type"]').val());
		});

	})

</script>

<script type="text/javascript">

	$('#cc-search-field').keypress(function(event) {

	    if (event.which == 13) // Enter key = keycode 13
	    {
	        searchCC();
	        return false;
	    }
	});

	$('#cc-search-button').click(function() {

	    searchCC();

	});

	function searchCC() {

	    var query = $('#cc-search-field').val();

	    $('#photo-error-message').html('').css('display', 'none');

	    $('#files').html('');

	    $.getJSON("https://api.unsplash.com/photos/search/", {query:query, per_page:9, client_id:'6deb3bd67bb4f2e23734ce938fc463f69dccab80ee24ec73e914910fcfc03e24'} , function(data) {
	        if (data) {
	            console.log(data);

	            $('#cc-search-results').show().html('<div class="clearfloat"></div>');

	            for (var i = 0; i < data.length; i++) {
	                var result = '<li class="cc-search-result" data-url="' + data[i].urls.regular + '" style="background-image: url(' + data[i].urls.small + ')"><div class="loading-overlay"><i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i></div><div class="selected-overlay"><svg width="54px" height="54px" viewBox="0 0 54 54" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">      <title>Check</title>      <defs></defs>      <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage">        <path d="M23.5,31.8431458 L17.5852419,25.9283877 C16.0248253,24.3679711 13.4910294,24.366835 11.9289322,25.9289322 C10.3700136,27.4878508 10.3665912,30.0234455 11.9283877,31.5852419 L20.4147581,40.0716123 C20.5133999,40.1702541 20.6159315,40.2626649 20.7218615,40.3488435 C22.2835669,41.8725651 24.794234,41.8626202 26.3461564,40.3106978 L43.3106978,23.3461564 C44.8771021,21.7797521 44.8758057,19.2483887 43.3137085,17.6862915 C41.7547899,16.1273729 39.2176035,16.1255422 37.6538436,17.6893022 L23.5,31.8431458 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z" id="Oval-2" stroke-opacity="0.198794158" stroke="#747474" fill-opacity="0.816519475" fill="#FFFFFF" sketch:type="MSShapeGroup"></path></g></svg></div></li>';

	                $('#cc-search-results').prepend(result);
	            };

	            if (data.length == 0) {
	                $('#cc-search-results').html('<div class="clearfloat"></div>');
	                $('#photo-error-message').html('No results. Please try a different search query').css('display', 'block');
	            };

	            $('#cc-search-results .cc-search-result').unbind('click').click(function() {

									var url = $(this).attr('data-url');

									var selected_tile = $(this);
									selected_tile.addClass('loading');

	                $('#cc-search-results .cc-search-result').removeClass('selected');

									Dropzone.forElement('#dropzone').removeAllFiles();

									// Upload file
					      	$.ajaxSetup({
												headers: {
													'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
													'Content-type': 'application/json'
												}
									});

									$.ajax({
											type:"POST",
											url: "/upload",
											dataType: "json",
											data:  JSON.stringify({type: 'image', url: url, cc: true}),
											processData: false,
											success: function(response) {

												$('#cc-search-results .cc-search-result').removeClass('selected loading');

												if (response.success == '200')
												{
													selected_tile.addClass('selected');
													$('#{{ $input_id }}').val(response.filename);
													$('#file-preview-filename').html(response.filename);
													$('#file-preview-thumbnail').css('background-image','url(https://s3.amazonaws.com/xmovement/uploads/images/small/' + response.filename + ')');
													$('.current-file-preview').addClass('visible');
												}

											},
											error: function(response) {

												$('#cc-search-results .cc-search-result').removeClass('selected loading');

												console.log('error - ' + response);

											}
									});
	            });

	        }
	    })
	    .fail(function( jqxhr, textStatus, error ) {
	        var err = textStatus + ", " + error;
	        console.log( "Request Failed: " + err );

	        $('#cc-search-results').html('<div class="clearfloat"></div>');
	        $('#photo-error-message').html('No results. Please try a different search query').css('display', 'block');
	    });
	}

</script>
