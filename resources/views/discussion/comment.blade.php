<li class="comment" id="comment-{{ $comment->id }}">

	<a target="_self" href="{{ action('UserController@profile', $comment->user) }}" class="user-avatar" style="background-image:url('{{ ResourceImage::getProfileImage($comment->user, 'medium') }}')"></a>

	<p class="comment-header">
		<a target="_self" href="{{ action('UserController@profile', $comment->user) }}">
			{{ $comment->user->name }}
		</a>

		@if(isset($comment->parent))
			<span class="reply-header">
				<i class="fa fa-comments"></i>
				{{ $comment->parent->user->name }}
			</span>
		@endif

		<span class="created-timestamp">
			• {{ $comment->created_at->diffForHumans() }}
		</span>
	</p>

	<p class="comment-body">
		{!! nl2br($comment->text) !!}
	</p>

	@if($authenticated_user && !$comment->commentTarget->locked)

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

			@if(!$comment->in_reply_to_comment_id)
				<span class="comment-action-button reply-to-comment-button">
					{{ trans('discussion.reply') }}
				</span>
			@endif

			@if(Gate::forUser($authenticated_user)->allows('destroy', $comment))

				<span class="comment-action-button destroy-comment-button" data-comment-id="{{ $comment->id }}" data-delete-confirmation="{{ trans('discussion.comment_delete_confirmation') }}">
					{{ trans('discussion.delete') }}
				</span>

			@endif

			@if(Gate::forUser($authenticated_user)->allows('report', $comment))

				<span class="comment-action-button report-comment-button" data-comment-id="{{ $comment->id }}" data-report-confirmation="{{ trans('discussion.comment_report_confirmation') }}">
					<span class="idle-state">
						{{ trans('discussion.report') }}
					</span>
					<span class="reported-state">
						{{ trans('discussion.reported') }}
					</span>
				</span>

			@endif

			<div class="clearfloat"></div>

		</div>

		<div class="post-reply-container">

			@include('discussion.comment-composer', ['authenticated_user' => $authenticated_user, 'comment' => $comment])

		</div>

	@endif

	<ul class="comment-replies">
		@foreach($comment->children as $reply)
			@include('discussion.comment', ['comment' => $reply, 'authenticated_user' => $authenticated_user])
		@endforeach
	</ul>

</li>
