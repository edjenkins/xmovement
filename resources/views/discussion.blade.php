<!-- <iframe src="http://xm.local" allowtransparency="true" frameborder="0" scrolling="no" tabindex="0" title="Discussion" width="100%" style="width: 1px !important; min-width: 100% !important; border: none !important; overflow: hidden !important; height: 299px !important;" horizontalscrolling="no" verticalscrolling="no"></iframe> -->

<ul id="comments-container"></ul>

@if (Auth::guest())

<p>
	Please sign in to comment
</p>

@else

<div class="post-comment-container">

	@include('discussion.comment-composer', ['authenticated_user' => Auth::user()])

</div>

@endif

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="{{ URL::asset('js/brainsocket/brain-socket.min.js') }}"></script>
<script src="{{ URL::asset('js/discussion.js') }}"></script>
