// Create idea

$(document).ready(function() {

	$('.slider').slider({
	    min: 5,
	    max: 45,
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
		step: 5
	})
	.slider('float');

	$('.slider').slider('value', parseInt($('.slider').attr('data-value')));
})

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
    if (($('#form-page-' + step).length == 0) || $('.idea-form').hasClass('has-errors')) { return; }

    $('.idea-form').attr('data-current-step', step);
    $('.form-page').removeClass('visible');
    $('#form-page-' + step).addClass('visible')
    $('#page-title').html($('#form-page-' + step).attr('data-title'));
    $('#form-page-' + step + ' input:text, #form-page-' + step + ' textarea').first().focus();
}
