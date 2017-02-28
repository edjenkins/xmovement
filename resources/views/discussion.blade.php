<?php
$locked = isset($locked) ? $locked : false;
$target_id = isset($target_id) ? $target_id : null;
$target_type = isset($target_type) ? $target_type : null;
$idea_id = isset($idea_id) ? $idea_id : null;
?>

<div class="discussion-wrapper" data-target-id="{{ $target_id }}" data-target-type="{{ $target_type }}" data-idea-id="{{ $idea_id }}">

	<ul class="comments-container"></ul>

	@if (Auth::guest())

	<a target="_self" href="{{ action('Auth\AuthController@login') }}" class="sign-in-required">
		{{ trans('discussion.signin') }}
	</a>

	@else

		<div class="post-comment-container">

			@include('discussion.comment-composer', ['authenticated_user' => Auth::user()])

		</div>

	@endif

</div>

<script type="text/javascript">
	var current_user_id = <?php if (Auth::guest()) { echo '0'; } else { echo Auth::user()->id; } ?>;
	var web_scoket_url = (location.host.includes('.local')) ? 'ws://' + location.host + ':' + {{ getenv('BRAINSOCKET_PORT') }} : 'wss://' + location.host + '/wss/';
</script>

<script src="{{ URL::asset('js/vendor/brainsocket/brain-socket.min.js') }}"></script>
<script src="{{ URL::asset('js/discussion.js') }}"></script>
