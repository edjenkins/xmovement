$(document).ready(function() {

	$('.vote-button').click(function() {

		var vote_button = $(this);

		var vote_direction = $(this).attr('data-vote-direction');

		var design_module_id = $(this).attr('data-design-module-id');

		$.ajaxSetup({
	        headers: {
	        	'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
	        	'Content-type': 'application/json'
	        }
		});

	    $.ajax({
	        type:"POST",
	        url: '/design_module/vote',
	        dataType: "json",
	        data:  JSON.stringify({design_module_id: design_module_id, vote_direction: vote_direction}),
	        processData: false,
	        success: function(response) {
			  
				// Success
				console.log(response['data']);
				
				var vote_count_element = vote_button.parents('.voting-controls').children('.vote-count').children('p');
				
				var vote_count = parseInt(vote_count_element.html());

				vote_count = (vote_direction == 'up') ? (vote_count + 1) : (vote_count - 1);

				vote_count_element.html(vote_count);

				showJSflash('Your vote was successful', 'flash-success');
	        
	        },
	        error: function(response) {
				
				// Error	
				alert( "error" );

				showJSflash('Your vote failed', 'flash-danger');

	        }
	    });

	});

})