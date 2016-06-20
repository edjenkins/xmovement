$(document).ready(function() {

    addHandlers();

    $('.submit-poll-option-container #submit-button').click(function() {

        var submit_button = $(this);

        submit_button.html('Submitting..');

        var submission = $('#poll-contribution').val();
        var poll_id = $(this).attr('data-poll-id');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Content-type': 'application/json'
            }
        });

        $.ajax({
            type:"POST",
            url: '/design/poll/option/submit',
            dataType: "json",
            data:  JSON.stringify({poll_id: poll_id, submission: submission}),
            processData: false,
            success: function(response) {

                // Success

				if (response["meta"]["success"])
				{
	                showJSflash('Thanks for your submission', 'flash-success');

	                $('.poll-options-list').append(response["data"]["element"]);

					$('#poll-contribution').val('');
				}
				else
				{
					showJSflash(response["errors"][0], 'flash-danger');
				}

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
    $('.vote-container.poll-option-vote-container .vote-button').off("click").click(function() {

        var vote_button = $(this);
        var vote_container = $(this).parents('.vote-controls').parents('.vote-container');

        var vote_direction = $(this).attr('data-vote-direction');
        var votable_id = $(this).attr('data-votable-id');
        var votable_type = $(this).attr('data-votable-type');

        addVote(vote_button, vote_container, vote_direction, votable_id, votable_type);

    });
}
