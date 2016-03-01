// Create event

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

$("input").keyup(function (e) {
    if ((e.keyCode == 9) || (e.keyCode == 13)) {
        nextStep();
    }
    e.preventDefault();
});

$(document).keydown(function(e) {
    switch(e.which) {
        case 37: // left
        previousStep();
        break;

        case 39: // right
        nextStep();
        break;

        default: return;
    }
    e.preventDefault();
});