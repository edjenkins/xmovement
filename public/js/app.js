//app.js

$(document).ready(function() {

	$(window).scroll(function() {

		if ($(window).scrollTop() > 50) {
			$('body').removeClass('fade-nav');
		} else {
			$('body').addClass('fade-nav');
		}

	});

});


// Creative Commons image search

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

            $('#cc-search-results').html('<div class="clearfloat"></div>');
            
            for (var i = 0; i < data.length; i++) {
                var result = '<li class="cc-search-result" data-url="' + data[i].urls.regular + '" style="background-image: url(' + data[i].urls.small + ')"></li>';

                $('#cc-search-results').prepend(result);
            };

            if (data.length == 0) {
                $('#cc-search-results').html('<div class="clearfloat"></div>');
                $('#photo-error-message').html('No results. Please try a different search query').css('display', 'block');
            };

            $('#cc-search-results .cc-search-result').unbind('click').click(function() {

                $('#cc-search-results .cc-search-result').removeClass('selected');
                $(this).addClass('selected');
                $('#uploaded-photo').val($(this).attr('data-url'));

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


/*jslint unparam: true */
/*global window, $ */
$(function () {
    'use strict';
    // Change this to the location of your server-side upload handler:
    var url = '/img/';
    $('#fileupload').fileupload({
        url: url,
        dataType: 'json',
        done: function (e, data) {
            
            $('#progress').slideUp(300);

            $.each(data.result.files, function (index, file) {
                
                $('#cc-search-field').val('');
                $('#cc-search-results').html('<div class="clearfloat"></div>');
				$('#photo-error-message').html('').css('display', 'none');

            	if (file.error) {

	            	$('#upload-button-text').html('Failed');
	            	$('#fileinput-button').removeClass('btn-success').addClass('btn-danger');

	            	setTimeout(function() {
	            		$('#upload-button-text').html('Choose Photo');
	            	 	$('#fileinput-button').removeClass('btn-danger').addClass('btn-success');
	            	 }, 2000);

            		$('#photo-error-message').html(file.error).css('display', 'block');

	                $('#files').html('');
		            $('#uploaded-photo').val('');

		            $('#progress .progress-bar').css('width', '0%');

            	} else {

	            	$('#upload-button-text').html('Uploaded');
	            	$('#fileinput-button').removeClass('btn-danger').addClass('btn-success');

	            	setTimeout(function() {
	            		$('#upload-button-text').html('Choose Photo');
	            	 	$('#fileinput-button').removeClass('btn-danger').addClass('btn-success');
	            	 }, 2000);

            		$('#photo-error-message').html('').css('display', 'none');

	                $('#files').html('<img src="/img/uploads/'+file.name+'" style="max-wi" />');
		            $('#uploaded-photo').val(document.location.origin + '/img/uploads/' + file.name);

            	}
            });
        },
        progressall: function (e, data) {
            
            $('#progress').slideDown(300);

            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#progress .progress-bar').css({'width': progress + '%'});
            if (progress < 100) {
            	$('#upload-button-text').html('Uploading');
	            $('#fileinput-button').removeClass('btn-danger').addClass('btn-success');
            }
        }
    }).prop('disabled', !$.support.fileInput)
        .parent().addClass($.support.fileInput ? undefined : 'disabled');
});

// Create event
$('.step-button').click(function() {

    if ($(this).attr('data-type') == 'next') {
        nextStep();    
    } else if ($(this).attr('data-type') == 'previous') {
        previousStep();
    }
    

});

function nextStep()
{
    var step = $('.idea-form').attr('data-current-step');
    step++;
    showStep(step);
}

function previousStep()
{
    var step = $('.idea-form').attr('data-current-step');
    step--;
    showStep(step);
}

function showStep(step)
{
    if ($('#form-page-' + step).length != 0) {
        $('.idea-form').attr('data-current-step', step);
        $('.form-page').removeClass('visible');
        $('#form-page-' + step).addClass('visible')
        var title = $('#form-page-' + step).attr('data-title');
        $('#page-title').html(title);
    }
}

$(document).keydown(function(e) {
    switch(e.which) {
        case 37: // left
        previousStep();
        break;

        case 39: // right
        nextStep();
        break;

        default: return; // exit this handler for other keys
    }
    e.preventDefault(); // prevent the default action (scroll / move caret)
});