@extends('layouts.app')

@section('content')

	<script type="text/javascript">
		var idea_url = '{{ url()->current() }}';
		var idea_name = '{{ $idea->name }}';
	</script>

	<div class="page-header">

        <h2 class="main-title">{{ $idea->name }}</h2>
		<h5 class="sub-title">Organized by <a href="{{ action('UserController@profile', $idea->user_id) }}">{{ $idea->user->name or $idea->user_id }}</a></h5>

	</div>

	<div class="container">

	    <div class="row">
	    	<div class="col-md-3 col-md-push-9 hidden-sm hidden-xs">

	    		<div class="column side-column">

					@include('ideas/side-column')

	    		</div>

    		</div>
	    	<div class="col-md-9 col-md-pull-3">

	    		<div class="column main-column">

	    			<div class="idea-media" style="background-image: url('{{ ResourceImage::getImage($idea->photo, 'large') }}')"></div>

					@include('ideas/progress')

	    			<p class="idea-description">
	    				{{ $idea->description }}
	    			</p>

	    			<div class="mobile-sidebar hidden-md hidden-lg">

    					@include('ideas/side-column')

    				</div>

					@if (count($idea->proposals) > 0)

						<div class="proposals-container hidden-xs">

			    			<div class="section-header">
								<h2>Proposals</h2>
								<a href="{{ action('ProposeController@index', $idea) }}">View all</a>
							</div>

							<div class="proposals-wrapper">

								@foreach ($idea->proposals->take(3) as $index => $proposal)
									<div class="col-xs-12 col-sm-6 col-md-4">
										@include('propose/tile', ['proposal' => $proposal, 'index' => $index])
									</div>
								@endforeach

								<div class="clearfloat"></div>

							</div>

						</div>

					@endif

					<br />

					<div class="section-header">
						<h2>Discussion</h2>
					</div>

	    			@include('disqus')

	    		</div>

	    	</div>
	    </div>
	</div>

	@can('support', $idea)

		@include('modals/support')

	@endcan

	<?php Session::set('redirect', Request::url()); ?>

	<script type="text/javascript">

		var auth_type = '{{ Session::pull("auth_type") }}';
		var is_authorized = '{{ Auth::check() ? true : false }}';
		var show_support = '{{ Session::pull("show_support") ? true : false }}';

	</script>

	<script src="/js/ideas/view.js"></script>

@endsection
