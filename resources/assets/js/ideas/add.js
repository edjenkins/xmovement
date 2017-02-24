// Create idea

$(document).ready(function() {

	$('#idea-duration-slider').slider({
	    min: 3,
	    max: 21,
		change: function(event, ui) {
	    	var input_id = $(this).attr('data-input-id');
			$('#' + input_id).val(ui.value);
	    }
	})
	.slider('pips', {
	    handle: false,
	    pips: true,
	    first: 'label',
	    last: 'label',
	    rest: 'label',
		step: 3
	})
	.slider('float');

	$('#idea-duration-slider').slider('value', parseInt($('#idea-duration-slider').attr('data-value')));
})

function showStep(direction)
{
	$.fn.extend({
	    animateCss: function (animationName) {
	        var animationEnd = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';
	        $(this).addClass('animated ' + animationName).one(animationEnd, function() {
	            $(this).removeClass('animated ' + animationName);
	        });
	    }
	});

	var current_step = $('.idea-form').attr('data-current-step');
	var next_step = $('.idea-form').attr('data-current-step');

	var firstLoop = true;

	// Checks if the form page with the step id exists if not continues
	while (($('#form-page-' + next_step).length == 0) || firstLoop) {
		firstLoop = false;
		if (direction == 'next') { next_step++; }
		if (direction == 'previous') { next_step--; }
		if ((next_step < 0) || (next_step > 100)) {
			console.log('Page not found');
			return;
		}
	}

    $('.idea-form').attr('data-current-step', next_step);
    $('.form-page').removeClass('fadeIn fadeOut');

	$('#form-page-' + current_step).animateCss('fadeOut');

	setTimeout(function() {

		// Set page title/header
		$('#page-title').html($('#form-page-' + next_step).attr('data-title')).animateCss('tada');

		// Animate page transition
		$('#form-page-' + current_step).removeClass('visible');
		$('#form-page-' + next_step).addClass('visible');
		$('#form-page-' + next_step).animateCss('fadeIn');

		// Focus on first field
		$('#form-page-' + next_step + ' input:text, #form-page-' + next_step + ' textarea').first().focus();

		// Set textareas to expand
		$('textarea').expanding();
	}, 300);
}
