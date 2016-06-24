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

        var submission;

        switch (submission_type) {

            case '1':
            // Text submission
            submission = {text: $('.submission-type-wrapper[data-type-id="' + submission_type + '"] input').val()};
            break;

            case '2':
            // Image submission
            submission = {image: dropzone_uploaded_file, description: $('.submission-type-wrapper[data-type-id="' + submission_type + '"] #item-description').val()};
            break;

            case '3':
            // Video submission
            submission = {video: $('.submission-type-wrapper[data-type-id="' + submission_type + '"] #video-input').val(), description: $('.submission-type-wrapper[data-type-id="' + submission_type + '"] #item-description').val()};
            break;

            case '4':
            // File submission
            submission = {file: dropzone_uploaded_file, description: $('.submission-type-wrapper[data-type-id="' + submission_type + '"] #item-description').val()};
            break;

        }



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

                    $('.submission-type-wrapper input').val('');

                    addHandlers();

                    if ((submission_type == '2') || (submission_type == '4'))
                    {
                        Dropzone.forElement('#dropzone').removeAllFiles();
                    }
                }
				else
				{
					showJSflash(response["errors"][0], 'flash-danger');
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
