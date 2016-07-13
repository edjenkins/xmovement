window.app = {};

app.BrainSocket = new BrainSocket(
        new WebSocket('ws://xm.local:8080'),
        new BrainSocketPubSub()
);

app.BrainSocket.Event.listen('comment.posted',function(msg)
{
	console.log(msg);
	$(msg.client.view).hide().appendTo($('#comments-container')).slideDown(300);
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
	// Get comment from textarea
	var comment = $('#comment-text-input').val();
	// Clear textarea
	$('#comment-text-input').val('');
	app.BrainSocket.message('comment.posted', { url: window.location.href, comment: comment });
});

$(document).ready(function() {

	$.getJSON("/api/comments/view", {url: window.location.href} , function(response) {

		if (response) {

			$.each(response.data.comments, function(index, comment) {

				$('#comments-container').append(comment.view);

			})
		}
	});

});
