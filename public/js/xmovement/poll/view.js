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
            url: '/design/poll/option/submit/',
            dataType: "json",
            data:  JSON.stringify({poll_id: poll_id, submission: submission}),
            processData: false,
            success: function(response) {
              
                // Success              
                
                showJSflash('Thanks for your submission', 'flash-success');

                $('.poll-options-list').append(response["data"]["element"]);

                addHandlers();

                $('#poll-contribution').val('')

                submit_button.html('Submit');
            
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
    $('.vote-container.poll-option-vote-container .vote-button').click(function() {

        var vote_button = $(this);
        var vote_container = $(this).parents('.vote-controls').parents('.vote-container');
        
        var vote_direction = $(this).attr('data-vote-direction');
        var votable_id = $(this).attr('data-votable-id');
        var votable_type = $(this).attr('data-votable-type');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Content-type': 'application/json'
            }
        });

        $.ajax({
            type:"POST",
            url: '/vote/' + votable_type,
            dataType: "json",
            data:  JSON.stringify({votable_id: votable_id, votable_type: votable_type, vote_direction: vote_direction}),
            processData: false,
            success: function(response) {
              
                // Success              
                var vote_count = (vote_direction == 'up') ? (parseInt(vote_container.find('.vote-count').html()) + 1) : (parseInt(vote_container.find('.vote-count').html()) - 1);

                vote_container.find('.vote-count').html(vote_count);

                vote_container.removeClass('positive-vote negative-vote')

                if (vote_count < 0)
                {
                    vote_container.addClass('negative-vote');
                }
                else if (vote_count > 0)
                {
                    vote_container.addClass('positive-vote');
                }

                vote_container.find('.vote-button').removeClass('voted');

                vote_button.addClass('voted');

                showJSflash('Your vote was successful', 'flash-success');
            
            },
            error: function(response) {
                
                // Error
                console.log(response);
                
                showJSflash('Your vote failed', 'flash-danger');

            }
        });

    });
}