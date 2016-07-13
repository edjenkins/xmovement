<li class="comment">

	<a href="{{ action('UserController@profile', $comment->user) }}" class="user-avatar" style="background-image:url('{{ ResourceImage::getProfileImage($comment->user, 'medium') }}')"></a>

	<p class="comment-header">
		<a href="{{ action('UserController@profile', $comment->user) }}">{{ $comment->user->name }}</a>
		<span style="color: #CCC; margin-left: 10px">{{ $comment->created_at->diffForHumans() }}</span>
	</p>
	<p class="comment-body">
		{{ $comment->text }}
	</p>
	<p class="comment-footer">

		<i class="fa fa-angle-up comment-vote-up-button"></i>
		<span class="comment-vote-count">2</span>
		<i class="fa fa-angle-down comment-vote-down-button"></i>

		<span class="comment-reply-button">Reply</span>

		<span class="comment-share-button">Share</span>

		<div class="clearfloat"></div>

	</p>

</li>
