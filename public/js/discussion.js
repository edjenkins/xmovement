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

	$('#comment-text-input').keyup(function(e) {

		var code = e.keyCode ? e.keyCode : e.which;

		if (code == 13)
		{
			postComment();
		}

		e.preventDefault();

	});

	$.getJSON("/api/comments/view", {url: window.location.href} , function(response) {

		if (response) {

			$.each(response.data.comments, function(index, comment) {

				$('#comments-container').append(comment.view);

			})

			attachHandlers();
		}
	});

});
