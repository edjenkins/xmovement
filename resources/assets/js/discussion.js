function startListening()
{
	if (discussionLoaded == true) return;

	discussionLoaded = true;

	window.app = {};

	var attr = $('#comments-container').attr('data-url');

	if (!(typeof attr !== typeof undefined && attr !== false))
	{
		$('#comments-container').attr('data-url', document.location);
	}

	app.BrainSocket = new BrainSocket(
			new WebSocket(web_scoket_url),
			new BrainSocketPubSub()
	);

	app.BrainSocket.Event.listen('comment.posted',function(msg)
	{
		// Check comment is for current page
		if (msg.client.data.url == window.location.href)
		{
			if (msg.client.data.in_reply_to_comment_id)
			{
				// This is a reply
				$(msg.client.view).hide().appendTo($('#comment-' + msg.client.data.in_reply_to_comment_id).children('.comment-replies')).slideDown(300);
			}
			else
			{
				$(msg.client.view).hide().appendTo($('#comments-container[data-url="' + msg.client.data.url + '"]')).slideDown(300);
			}
			attachHandlers();
		}
	});

	app.BrainSocket.Event.listen('comment.error',function(msg)
	{
		if (msg.client.user_id == current_user_id)
		{
			alert(msg.client.errors[0]);
		}

		attachHandlers();
	});
}

function attachHandlers()
{
	$('.reply-to-comment-button').off('click').on('click', function(event)
	{
		var wrapper = $(this).parent();

		$('.post-reply-container').hide();
		$(this).parent().parent().children('.post-reply-container').show();
		$(this).parent().parent().children('.post-reply-container').find('textarea').expanding().focus();
	});

	// Add post comment handlers
	$('.post-comment-button').off('click').on('click', function(event)
	{
		var wrapper = $(this).parent();

		postComment(wrapper);
	});

	// Add post comment on enter handlers
	$('.comment-text-input').off('keypress').on('keypress', function(event) {

		var wrapper = $(this).parent().parent();

		var code = event.keyCode ? event.keyCode : event.which;

		if (code == 13)
		{
			event.preventDefault();
			postComment(wrapper);
		}

	});

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

$(document).ready(function() {

	fetchComments(window.location.href);

	startListening();

});

function fetchComments(url) {

	console.log('Fetching comments for - ' + url);

	$('#comments-container[data-url="' + url + '"]').html('');

	$.getJSON("/api/comment/view", {url: url} , function(response) {

		if (response) {

			$('#comments-container[data-url="' + url + '"]').html('');

			$.each(response.data.comments, function(index, comment) {

				$('#comments-container[data-url="' + url + '"]').append(comment.view);

			})

			attachHandlers();

			// startListening();
		}
	});

}

function postComment(wrapper)
{
	var in_reply_to_comment_id = wrapper.attr('data-in-reply-to-comment-id');

	in_reply_to_comment_id = (in_reply_to_comment_id) ? in_reply_to_comment_id : 0;

	// Get comment from textarea
	var comment = wrapper.find('textarea').val();

	// Clear textarea
	wrapper.find('textarea').val('').change();

	// Hide reply composer
	$('.post-reply-container').hide();

	// Post message
	var data = { url: window.location.href, comment: comment, in_reply_to_comment_id: in_reply_to_comment_id };
	app.BrainSocket.message('comment.posted', data);
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

function reportComment(report_button)
{
	if (report_button.hasClass('reported'))
		return; // This has been reported so cancel

	var result = confirm(report_button.attr('data-report-confirmation'));

	if (!result)
	    return; // User decided not to report this so cancel

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
				report_button.addClass('reported');
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