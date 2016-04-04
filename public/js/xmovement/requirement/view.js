$(document).ready(function() {

    addHandlers();

})

function addHandlers()
{
	$('.requirement-circle').off("click").click(function() {

		var requirement = $(this).parent();

		if (requirement.hasClass('filled'))
		{
			return;
		}
		else if (requirement.hasClass('filling'))
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
        var requirement_circle = requirement_space.find('.requirement-circle');
        var requirement_id = fill_button.attr('data-requirement-id');

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

                requirement_space.removeClass('not-filled filling').addClass('filled');

                var background_image = requirement_circle.attr('data-user-background');

                requirement_circle.css('background-image', 'url("' + background_image + '")');

                requirement_space.find('.user-filled').show();
                requirement_space.find('.user-not-filled').hide();
            
            },
            error: function(response) {
                
                // Error
                console.log(response);
                
                showJSflash('Your submission failed', 'flash-danger');

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

                // Close modal
                $('#requirement-invite-modal').modal('hide');

                $('.requirement-space').removeClass('filling').addClass('not-filled');
            
            },
            error: function(response) {
                
                // Error
                console.log(response);
                
                showJSflash('Invitation failed to send', 'flash-danger');

            }
        });   

    });
}