// Support button

$('#confirm-support-button').click(function() {

	support($(this).attr('data-user-id'), $(this).attr('data-idea-id'));
});

function support(user_id, idea_id)
{
	var g_recaptcha_response = $('.g-recaptcha-response').val();

	$.ajaxSetup({
        headers: {
        	'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        	'Content-type': 'application/json'
        }
	});

    $.ajax({
        type:"POST",
        url: "/api/support",
        dataType: "json",
        data:  JSON.stringify({user_id: user_id, idea_id: idea_id, captcha: g_recaptcha_response}),
        processData: false,
        success: function(response) {

        	$('#support-errors').html(''); // Clear errors

        	if (response.meta.success)
        	{
        		var button_text = (response.data.supporter_count == 1) ? "Supporter" : "Supporters";
	            $('.supporter-count').html(response.data.supporter_count);
				$('.supporter-subtitle').html(button_text);

				$('#support-modal').modal('hide');
                $('.supporters-tile-footer').addClass('visible');

                $('.support-button').hide();
                $('.temp-design-button').css('display', 'block');
			}
        	else
        	{
        		// Output errors
        		$.each(response.errors, function(index, value) {
        			$('#support-errors').append('<li>' + value + '</li>');
        		})
        	}
        },
        error: function(response) {
        	$('#support-errors').append('<li>Something went wrong!</li>');
        }
    });
}
