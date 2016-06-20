@extends('layouts.app')

@section('content')

	<div class="page-header">

        <h2 class="main-title">{{ $idea->name }}</h2>
		<h5 class="sub-title">Organized by <a href="{{ action('UserController@profile', $idea->user_id) }}">{{ $idea->user->name or $idea->user_id }}</a></h5>

	</div>

	<div class="container">

	    <div class="row">
	    	<div class="col-md-3 col-md-push-9 hidden-sm hidden-xs">

	    		<div class="column side-column">

	    			<div class="creator-tile" onClick="document.location = '{{ action('UserController@profile', $idea->user_id) }}';">
    					<div class="creator-avatar" style="background-image:url('/uploads/images/medium/{{ $idea->user->avatar }}')"></div>
    					<h4>{{ $idea->user->name }}</h4>
    					<h5 class="subtitle">Idea Creator</h5>
	    			</div>

	    			<div class="stats-tile supporters-tile">
    					<h3 class="supporter-count">{{ $idea->supporterCount() }}</h3>
	    				<h5 class="supporter-subtitle">Supporters</h5>
	    				<div class="stats-tile-footer supporters-tile-footer{{ $supported ? ' visible' : '' }}">You supported this idea</div>
    				</div>

	    			@include('action-button')

					@if ($idea->design_state == 'closed')

						<div class="info-tile">
							<div class="info-tile-content">
								<p>
									<i class="fa fa-info"></i>
									Design area opens in {{ $idea->designPhaseOpens() }}
								</p>
							</div>
						</div>

					@endif

					@if ($idea->proposal_state == 'closed')

						<div class="info-tile">
							<div class="info-tile-content">
								<p>
									<i class="fa fa-info"></i>
									Proposal area opens in {{ $idea->proposalPhaseOpens() }}
								</p>
							</div>
						</div>

					@endif

	    		</div>

    		</div>
	    	<div class="col-md-9 col-md-pull-3">

	    		<div class="column main-column">

	    			<div class="idea-media" style="background-image: url('/uploads/images/large/{{ $idea->photo }}')"></div>

					@include('ideas/progress')

	    			<p class="idea-description">
	    				{{ $idea->description }}
	    			</p>

	    			<div class="mobile-sidebar hidden-md hidden-lg">

    					<div class="stats-tile supporters-tile">
	    					<h3 class="supporter-count">{{ $idea->supporterCount() }}</h3>
		    				<h5 class="supporter-subtitle">Supporters</h5>
		    				<div class="stats-tile-footer supporters-tile-footer{{ $supported ? ' visible' : '' }}">You supported this idea</div>
	    				</div>

	    				@include('action-button')

    				</div>

					@if (count($idea->proposals) > 0)

						<div class="proposals-container hidden-xs">

			    			<h2 class="section-header">Proposals</h2>

							<div class="proposals-wrapper">

								@foreach ($idea->proposals->take(3) as $proposal)
									<div class="col-xs-12 col-sm-6 col-md-4">
										@include('propose/tile', ['proposal' => $proposal])
									</div>
								@endforeach

								<div class="clearfloat"></div>

							</div>

						</div>

					@endif

					<br />

					<h2 class="section-header">Discussion</h2>

	    			@include('disqus')

	    		</div>

	    	</div>
	    </div>
	</div>

	@can('support', $idea)

		@include('modals/support')

	@endcan

	<?php Session::flash('redirect', Request::url()); ?>

	<script type="text/javascript">

		var auth_type = '{{ Session::pull("auth_type") }}';
		var is_authorized = '{{ Auth::check() ? true : false }}';
		var show_support = '{{ Session::pull("show_support") ? true : false }}';

	</script>

	<script src="/js/ideas/view.js"></script>

@endsection
