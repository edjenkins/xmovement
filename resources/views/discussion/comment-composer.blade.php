<div class="user-avatar" style="background-image:url('{{ ResourceImage::getProfileImage($authenticated_user, 'medium') }}')"></div>

<div class="comment-composer-wrapper" data-in-reply-to-comment-id="{{ isset($comment) ? $comment->id : NULL }}">

	<textarea class="expanding comment-text-input" rows="1" name="text" placeholder="{{ isset($comment) ? trans('discussion.reply_text_placeholder') : trans('discussion.comment_text_placeholder') }}"></textarea>

	<button type="button" class="post-comment-button">
		<span class="idle-state">
			{{ isset($comment) ? trans('discussion.reply_button_idle') : trans('discussion.comment_button_idle') }}
		</span>
		<span class="posting-state">
			{{ isset($comment) ? trans('discussion.reply_button_posting') : trans('discussion.comment_button_posting') }}
		</span>
	</button>

	<ul class="error-list" id="comment-errors"></ul>

</div>
