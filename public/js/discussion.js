window.app = {};

app.BrainSocket = new BrainSocket(
        new WebSocket('ws://xm.local:8080'),
        new BrainSocketPubSub()
);

app.BrainSocket.Event.listen('comment.posted',function(msg)
{
	console.log(msg);
	$(msg.client.view).hide().appendTo($('#comments-container')).slideDown(300);

	attachHandlers();
});

app.BrainSocket.Event.listen('app.success',function(msg)
{
    console.log(msg);
});

app.BrainSocket.Event.listen('app.error',function(msg)
{
    console.log(msg);
});

$('#post-comment-button').click(function(event)
{
	postComment()
});

function postComment()
{
	// Get comment from textarea
	var comment = $('#comment-text-input').val();

	// Clear textarea
	$('#comment-text-input').val('').change();

	// Post message
	app.BrainSocket.message('comment.posted', { url: window.location.href, comment: comment });
}

function attachHandlers()
{
	// Add destroy handlers
	$('.destroy-comment-button').off('click').on('click', function() {

		destroyComment($(this));

	});

	// Add report handlers
	$('.report-comment-button').off('click').on('click', function() {

		reportComment($(this));

	});

	// Add vote handlers
	$('.comment-vote-container .vote-button').off('click').on('click', function() {

		var vote_button = $(this);
		var vote_container = $(this).parents('.vote-controls').parents('.comment-vote-container');

		var vote_direction = $(this).attr('data-vote-direction');
		var votable_id = $(this).attr('data-votable-id');
		var votable_type = $(this).attr('data-votable-type');

		addVote(vote_button, vote_container, vote_direction, votable_id, votable_type);

	});
}

function destroyComment(delete_button)
{
	var result = confirm(delete_button.attr('data-delete-confirmation'));

	if (!result)
	    return;

	var comment_id = delete_button.attr('data-comment-id');

	$.ajaxSetup({
        headers: {
        	'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        	'Content-type': 'application/json'
        }
	});

    $.ajax({
        type:"DELETE",
        url: "/api/comment/destroy",
        dataType: "json",
        data:  JSON.stringify({comment_id: comment_id}),
        processData: false,
        success: function(response) {

        	if (response.meta.success)
        	{
				// Remove element from DOM
				$('#comment-' + comment_id).remove();
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

$(document).ready(function() {

	$('#comment-text-input').keyup(function(e) {

		var code = e.keyCode ? e.keyCode : e.which;

		if (code == 13)
		{
			postComment();
		}

		e.preventDefault();

	});

	$.getJSON("/api/comment/view", {url: window.location.href} , function(response) {

		if (response) {

			$.each(response.data.comments, function(index, comment) {

				$('#comments-container').append(comment.view);

			})

			attachHandlers();
		}
	});

});

function reportComment(report_button)
{
	var result = confirm(report_button.attr('data-report-confirmation'));

	if (!result)
	    return;

	var comment_id = report_button.attr('data-comment-id');

	$.ajaxSetup({
        headers: {
        	'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        	'Content-type': 'application/json'
        }
	});

    $.ajax({
        type:"POST",
        url: "/api/report",
        dataType: "json",
        data:  JSON.stringify({reportable_id: comment_id, reportable_type: 'comment'}),
        processData: false,
        success: function(response) {

        	if (response.meta.success)
        	{
				report_button.html('Reported!');
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
