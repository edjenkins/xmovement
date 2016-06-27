$(document).ready(function() {

    addHandlers();

})

function setRequirementState(state, requirement_space)
{
    var requirement_circle = requirement_space.find('.requirement-circle');
    var requirement_id = requirement_space.attr('data-requirement-id');

    switch (state) {

        case 'filled':

            requirement_space.removeClass('not-filled filling').addClass('filled');
            requirement_circle.css('background-image', 'url("' + requirement_circle.attr('data-user-background') + '")');
            requirement_space.find('.filled-temp').show();
            requirement_space.find('.not-filled-temp').hide();

            break;

        case 'not-filled':

            requirement_space.removeClass('filled filling').addClass('not-filled');
            requirement_circle.css('background-image', 'none');
            requirement_space.find('.filled-temp').hide();
			requirement_space.find('.withdraw-from-requirement').hide();
            requirement_space.find('.not-filled-temp').show();

            break;
    }
}

function addHandlers()
{
	$('.requirement-circle').off("click").click(function() {

		var requirement = $(this).parent();

		if (requirement.hasClass('filled')) return;

        if (requirement.hasClass('filling'))
		{
			requirement.removeClass('filling').addClass('not-filled');
		}
		else
		{
			requirement.removeClass('not-filled').addClass('filling');
		}

	});

    $('.requirement-space .action-inputs .fill-button').off("click").click(function() {

        if (!confirm('Are you sure you can meet this requirement?')) return;

        var fill_button = $(this);
        var requirement_space = fill_button.parent().parent();
        var requirement_id = requirement_space.attr('data-requirement-id');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Content-type': 'application/json'
            }
        });

        $.ajax({
            type:"POST",
            url: '/design/requirement/submit',
            dataType: "json",
            data:  JSON.stringify({requirement_id: requirement_id, submission_type: 'fill'}),
            processData: false,
            success: function(response) {

                // Success

                showJSflash('Thanks for your submission', 'flash-success');

                requirement_space.attr('data-requirement-filled-id', response.data.requirement_filled_id);

                setRequirementState('filled', requirement_space);

            },
            error: function(response) {

                // Error
                console.log(response);

                showJSflash('Your submission failed', 'flash-danger');

            }
        });

    });

    $('.withdraw-from-requirement').off("click").click(function() {

        if (!confirm('Are you sure you want to withdraw from meeting this requirement?')) return;

        var remove_button = $(this);
        var requirement_space = remove_button.parent().parent().parent();
        var requirement_filled_id = requirement_space.attr('data-requirement-filled-id');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Content-type': 'application/json'
            }
        });

        $.ajax({
            type:"POST",
            url: '/design/requirement/withdraw',
            dataType: "json",
            data:  JSON.stringify({requirement_filled_id: requirement_filled_id}),
            processData: false,
            success: function(response) {

                // Success

                showJSflash('You have withdrawn', 'flash-success');

                setRequirementState('not-filled', requirement_space);

            },
            error: function(response) {

                // Error
                console.log(response);

                showJSflash('We couldn\'t withdraw you', 'flash-danger');

            }
        });

    });

    $('#send-invitation-button').off("click").click(function() {

        var send_invitation_button = $(this);
        var requirement_id = send_invitation_button.attr('data-requirement-id');

        var name = $('#invitation-name').val();
        var email = $('#invitation-email').val();
        var message = $('#invitation-message').val();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Content-type': 'application/json'
            }
        });

        $.ajax({
            type:"POST",
            url: '/design/requirement/submit',
            dataType: "json",
            data:  JSON.stringify({requirement_id: requirement_id, submission_type: 'invite', name: name, email: email, message: message, link: window.location.href}),
            processData: false,
            success: function(response) {

                // Success

                showJSflash('Your invitation was sent', 'flash-success');

                $('#requirement-invite-modal').modal('hide');

            },
            error: function(response) {

                // Error
                console.log(response);

                showJSflash('Invitation failed to send', 'flash-danger');

            }
        });

    });
}
