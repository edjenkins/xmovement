//app.js

var discussionLoaded = false;

$(document).ready(function() {

	// Scroll function for animated navbar
    $(window).scroll(function() {

		if ($(window).scrollTop() > 50) {
			$('body').removeClass('fade-nav');
		} else {
			$('body').addClass('fade-nav');
		}

	});

    // Hide flash messages
    setTimeout(function() { $('.flash').fadeOut(300, function() { $('.flash').remove(); }); }, 4000);

	// Vote button handler
    $('.design-task-vote-container .vote-button').click(function() {

        var vote_button = $(this);
        var vote_container = $(this).parents('.vote-controls').parents('.design-task-vote-container');

        var vote_direction = $(this).attr('data-vote-direction');
        var votable_id = $(this).attr('data-votable-id');
        var votable_type = $(this).attr('data-votable-type');

        addVote(vote_button, vote_container, vote_direction, votable_id, votable_type);

    });

	// Propose mode
	if ($('#selected_contributions').length != 0)
	{
		var selected_contributions = $('#selected_contributions').attr('data-original-values').split(',');
		$('#selected_contributions').val(selected_contributions);

		$('.proposal-button').click(function() {
			$(this).toggleClass('fa-square fa-check-square');
			var contribution_id = $(this).attr('data-contribution-id');
			var i = selected_contributions.indexOf(contribution_id);
			if(i != -1) {
				selected_contributions.splice(i, 1);
			} else {
				selected_contributions.push(contribution_id);
			}
			$('#selected_contributions').val(selected_contributions);
		})
	}

});

// Log action such as share button clicks
function logAction(data)
{
	data['url'] = window.location.href;

	$.ajaxSetup({
        headers: {
        	'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        	'Content-type': 'application/json'
        }
	});

    $.ajax({
        type:"POST",
        url: "/api/action/log",
        dataType: "json",
        data: JSON.stringify(data),
        processData: false,
        success: function(response) {

        	if (response.meta.success)
        	{
        		// Logged
			}
        	else
        	{
        		// Failed
        	}
        },
        error: function(response) {
        	// Failed
        }
    });
}

// Display a flash message from javascript
function showJSflash(message, type)
{
    var flash_message = '<div class="flash ' + type + '">' + message + '</div>';

    $('body').append(flash_message);

    $('.flash').show();

    setTimeout(function() { $('.flash').fadeOut(300, function() { $('.flash').remove(); }); }, 2000);
}

function addVote(vote_button, vote_container, vote_direction, votable_id, votable_type)
{
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

			console.log(response);

            if (!response['meta']['success'])
            {
                showJSflash(response['errors'][0], 'flash-danger');
            }
            else
            {
                // Success
                var vote_count = response['data']['vote_count'];

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
            }

        },
        error: function(response) {

            // Error
            console.log(response);

            showJSflash('Your vote failed', 'flash-danger');

        }
    });
}
