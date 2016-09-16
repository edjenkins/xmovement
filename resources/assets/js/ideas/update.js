$(document).ready(function() {

	// Add the handlers for destroying updates
	addDestroyUpdateHandlers();

	$('#post-update-button').click(function() {

		postUpdate($(this), $(this).attr('data-user-id'), $(this).attr('data-idea-id'));

	});

})

function postUpdate(button, user_id, idea_id)
{
	button.addClass('posting');

	var text = $('#update-text-input').val();

	$.ajaxSetup({
        headers: {
        	'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        	'Content-type': 'application/json'
        }
	});

    $.ajax({
        type:"POST",
        url: "/api/update/add",
        dataType: "json",
        data:  JSON.stringify({user_id: user_id, idea_id: idea_id, text: text}),
        processData: false,
        success: function(response) {

        	if (response.meta.success)
        	{
				$('#update-text-input').val('');
				$(response.data.element).hide().prependTo($('.updates-list')).slideDown(300);
				addDestroyUpdateHandlers();
			}
        	else
        	{
        		// Output errors
        		$.each(response.errors, function(index, value) {
        			alert(value);
        		})
        	}
			button.removeClass('posting');
			$('#update-text-input').input();
        },
        error: function(response) {
			console.log(response);
        	alert('Something went wrong!');
			button.removeClass('posting');
        }
    });
}

function destroyUpdate(delete_button)
{
	var result = confirm(delete_button.attr('data-delete-confirmation'));

	if (!result)
	    return;

	var update_id = delete_button.attr('data-update-id');

	$.ajaxSetup({
        headers: {
        	'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        	'Content-type': 'application/json'
        }
	});

    $.ajax({
        type:"DELETE",
        url: "/api/update/destroy",
        dataType: "json",
        data:  JSON.stringify({update_id: update_id}),
        processData: false,
        success: function(response) {

        	if (response.meta.success)
        	{
				// Remove element from DOM
				$('#update-' + update_id).remove();
			}
        	else
        	{
        		// Output errors
        		$.each(response.errors, function(index, value) {
        			alert(value);
        		})
        	}
        },
        error: function(response) {
			console.log(response);
        	alert('Something went wrong!');
        }
    });
}

function addDestroyUpdateHandlers()
{
	$('.destroy-update-button').off('click').on('click', function() {

		destroyUpdate($(this));

	});
}
