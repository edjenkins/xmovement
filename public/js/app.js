//app.js

$(document).ready(function() {

    $(window).scroll(function() {

		if ($(window).scrollTop() > 50) {
			$('body').removeClass('fade-nav');
		} else {
			$('body').addClass('fade-nav');
		}

	});

    // Hide flash messages
    setTimeout(function() { $('.flash').fadeOut(300, function() { $('.flash').remove(); }); }, 2000);

});

function getURLParam(param)
{
    var pageURL = window.location.search.substring(1);
    var URLVariables = pageURL.split('&');
    for (var i = 0; i < URLVariables.length; i++)
    {
        var parameterName = URLVariables[i].split('=');
        if (parameterName[0] == param)
        {
            return parameterName[1];
        }
    }
}

function showJSflash(message, type)
{
    var flash_message = '<div class="flash ' + type + '">' + message + '</div>';

    $('body').append(flash_message);
    
    setTimeout(function() { $('.flash').fadeOut(300, function() { $('.flash').remove(); }); }, 2000);
}

$(document).ready(function() {

    $('.vote-container.design-module-vote-container .vote-button').click(function() {

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
              
                if (!response['meta']['success'])
                {
                    showJSflash('Your vote failed', 'flash-danger');
                }
                else
                {
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
                }
            
            },
            error: function(response) {
                
                // Error
                console.log(response);
                
                showJSflash('Your vote failed', 'flash-danger');

            }
        });

    });

})