<li class="comment" id="comment-{{ $comment->id }}">

	<a href="{{ action('UserController@profile', $comment->user) }}" class="user-avatar" style="background-image:url('{{ ResourceImage::getProfileImage($comment->user, 'medium') }}')"></a>

	<p class="comment-header">
		<a href="{{ action('UserController@profile', $comment->user) }}">{{ $comment->user->name }}</a>
		<span class="created-timestamp">{{ $comment->created_at->diffForHumans() }}</span>
	</p>
	<p class="comment-body">
		{!! nl2br($comment->text) !!}
	</p>
	<div class="comment-footer">

		<div class="comment-vote-container {{ ($comment->voteCount() == 0) ? '' : (($comment->voteCount() > 0) ? 'positive-vote' : 'negative-vote') }}">
			<div class="vote-controls">
				<div class="vote-button vote-up {{ ($comment->userVote() > 0) ? 'voted' : '' }}" data-vote-direction="up" data-votable-type="comment" data-votable-id="{{ $comment['id'] }}">
					<i class="fa fa-2x fa-angle-up"></i>
				</div>
				<div class="vote-count">
					{{ $comment->voteCount() }}
				</div>
				<div class="vote-button vote-down {{ ($comment->userVote() < 0) ? 'voted' : '' }}" data-vote-direction="down" data-votable-type="comment" data-votable-id="{{ $comment['id'] }}">
					<i class="fa fa-2x fa-angle-down"></i>
				</div>
			</div>
		</div>

		<span class="comment-action-button">Reply</span>

		@can('destroy', $comment)

			<span class="comment-action-button destroy-comment-button" data-comment-id="{{ $comment->id }}" data-delete-confirmation="{{ trans('idea.comment_delete_confirmation') }}">Delete</span>

		@endcan

		@can('flag', $comment)

			<span class="comment-action-button">Flag</span>

		@endcan

		<div class="clearfloat"></div>

	</div>

</li>
