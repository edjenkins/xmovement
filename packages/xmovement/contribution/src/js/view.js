$(document).ready(function() {

    $('.submission-type-wrapper:first-child').addClass('active');
    $('.submit-contribution-submission-container #submit-button').attr('data-type-id', $('.submission-type-wrapper:first-child').attr('data-type-id'));

    var $selects = $('select');

    $selects.easyDropDown({
        wrapperClass: 'flat custom-dropdown',
        onChange: function(selected){
            
            current_submission_type = selected.value;

            $('.submission-type-wrapper').removeClass('active');

            $('.submission-type-wrapper[data-type-id="' + selected.value + '"]').addClass('active');
        }
    });

    addHandlers();

    $('.submit-contribution-submission-container #submit-button').click(function() {

        var submit_button = $(this);
        var contribution_id = $(this).attr('data-contribution-id');

        submit_button.html('<i class="fa fa-circle-o-notch fa-spin"></i>');
        
        var submission_type = $("#submission-type-selector").val();
        var submission = $('.submission-type-wrapper[data-type-id="' + submission_type + '"] input').val();
        var data = JSON.stringify({contribution_id: contribution_id, submission_type: submission_type, submission: submission, });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Content-type': 'application/json'
            }
        });

        $.ajax({
            type:"POST",
            url: '/design/contribution/submission/submit',
            dataType: "json",
            data:  data,
            processData: false,
            success: function(response) {
              
                // Success

                if (response.meta.success)
                {
                    showJSflash('Thanks for your submission', 'flash-success');

                    $('.contribution-submissions-list').append(response["data"]["element"]);

                    $('#text-contribution').val('');

                    $('#video-contribution').val('');

                    addHandlers();
                }
                else
                {
                    showJSflash('There was an issue with the submission', 'flash-danger');
                }

            },
            error: function(response) {
                
                // Error
                console.log(response);
                
                showJSflash('Your submission failed', 'flash-danger');

            },
            complete: function(response) {

                submit_button.html('Submit');
            }

        });

    });

})

function addHandlers()
{
    $('.vote-container.contribution-submission-vote-container .vote-button').off("click").click(function() {

        var vote_button = $(this);
        var vote_container = $(this).parents('.vote-controls').parents('.vote-container');
        
        var vote_direction = $(this).attr('data-vote-direction');
        var votable_id = $(this).attr('data-votable-id');
        var votable_type = $(this).attr('data-votable-type');

        addVote(vote_button, vote_container, vote_direction, votable_id, votable_type);

    });
}