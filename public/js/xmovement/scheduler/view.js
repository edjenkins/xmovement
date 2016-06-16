$(document).ready(function() {

    addHandlers();

    $('.submit-scheduler-option-container #submit-button').click(function() {

        var submit_button = $(this);

        submit_button.html('Submitting..');

        var submission = $('#scheduler-contribution').val();
        var scheduler_id = $(this).attr('data-scheduler-id');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Content-type': 'application/json'
            }
        });

        $.ajax({
            type:"POST",
            url: '/design/scheduler/option/submit',
            dataType: "json",
            data:  JSON.stringify({scheduler_id: scheduler_id, submission: submission}),
            processData: false,
            success: function(response) {

                // Success

                showJSflash('Thanks for your submission', 'flash-success');

                $('.scheduler-options-list').append(response["data"]["element"]);

				$('.scheduler-options-list .clearfloat').remove();

				$('.scheduler-options-list').append('<div class="clearfloat"></div>');

                $('#scheduler-contribution').val('');

                submit_button.html('Submit');

                addHandlers();

            },
            error: function(response) {

                // Error
                console.log(response);

                showJSflash('Your submission failed', 'flash-danger');

                submit_button.html('Submit');

            }
        });

    });

})

function addHandlers()
{
    $('.vote-container.scheduler-option-vote-container .vote-button').off("click").click(function() {

        var vote_button = $(this);
        var vote_container = $(this).parents('.vote-controls').parents('.vote-container');

        var vote_direction = $(this).attr('data-vote-direction');
        var votable_id = $(this).attr('data-votable-id');
        var votable_type = $(this).attr('data-votable-type');

        addVote(vote_button, vote_container, vote_direction, votable_id, votable_type);

    });
}

$(document).ready(function() {

    var today = new Date();

	$('#scheduler-contribution').daterangepicker({
	    "opens": "center",
	    "drops": "up",
	    "singleDatePicker": true,
	    "timePicker": true,
	    "timePicker24Hour": true,
	    "autoApply": true,
	    "alwaysShowCalendars": true,
		"minDate": moment().format('YYYY-MM-DD'),
        locale: {
            format: 'YYYY-MM-DD H:mm:ss'
        }
	});

});
