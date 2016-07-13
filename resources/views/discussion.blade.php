<!-- <iframe src="http://xm.local" allowtransparency="true" frameborder="0" scrolling="no" tabindex="0" title="Discussion" width="100%" style="width: 1px !important; min-width: 100% !important; border: none !important; overflow: hidden !important; height: 299px !important;" horizontalscrolling="no" verticalscrolling="no"></iframe> -->

<ul id="comments-container"></ul>

@if (Auth::guest())

<p>
	Please sign in to comment
</p>

@else

<div class="post-comment-container">

	<div class="user-avatar" style="background-image:url('{{ ResourceImage::getProfileImage(Auth::user(), 'medium') }}')"></div>

	<div class="comment-composer-wrapper">

		<textarea class="expanding" rows="1" id="comment-text-input" name="text" placeholder="{{ trans('idea.comment_text_placeholder') }}"></textarea>

		<button type="button" class="post-comment-button" id="post-comment-button">
			<span class="idle-state">
				{{ trans('idea.comment_button_idle') }}
			</span>
			<span class="posting-state">
				{{ trans('idea.comment_button_posting') }}
			</span>
		</button>

		<ul class="error-list" id="comment-errors"></ul>

	</div>

</div>

@endif

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="{{ URL::asset('js/brainsocket/brain-socket.min.js') }}"></script>
<script src="{{ URL::asset('js/discussion.js') }}"></script>
