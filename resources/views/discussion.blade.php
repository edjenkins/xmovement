<ul id="comments-container"></ul>

@if (Auth::guest())

<a href="{{ action('Auth\AuthController@login') }}" class="sign-in-required">
	{{ trans('discussion.signin') }}
</a>

@else

<div class="post-comment-container">

	@include('discussion.comment-composer', ['authenticated_user' => Auth::user()])

</div>

@endif

<script type="text/javascript">
	var current_user_id = <?php if (Auth::guest()) { echo '0'; } else { echo Auth::user()->id; } ?>;
	var web_scoket_url = (location.host.includes('.local')) ? 'ws://' + location.host + ':' + {{ getenv('BRAINSOCKET_PORT') }} : 'wss://' + location.host + '/wss/';
</script>

<script src="{{ URL::asset('js/vendor/brainsocket/brain-socket.min.js') }}"></script>
<script src="{{ URL::asset('js/discussion.js') }}"></script>
