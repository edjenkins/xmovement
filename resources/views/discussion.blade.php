<ul id="comments-container"></ul>

@if (Auth::guest())

<p class="sign-in-required">
	{{ trans('discussion.signin') }}
</p>

@else

<div class="post-comment-container">

	@include('discussion.comment-composer', ['authenticated_user' => Auth::user()])

</div>

@endif

<script type="text/javascript">
	var current_user_id = <?php if (Auth::guest()) { echo '0'; } else { echo Auth::user()->id; } ?>;
	var web_scoket_url = 'ws://' + location.host + ':' + {{ getenv('BRAINSOCKET_PORT') }};
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="{{ URL::asset('js/brainsocket/brain-socket.min.js') }}"></script>
<script src="{{ URL::asset('js/discussion.js') }}"></script>
