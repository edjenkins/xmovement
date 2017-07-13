@extends('layouts.app', ['bodyclasses' => 'medium-grey'])

@section('content')

	<div class="page-header">

        <h2 class="main-title">{{ $idea->name }}</h2>
		<h5 class="sub-title">{{ trans('idea.organized_by', ['user_name' => $idea->user->name]) }}</h5>

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

					<div class="idea-section">

		    			<div class="idea-media" style="background-image: url('{{ ResourceImage::getImage($idea->photo, 'large') }}')">

							@if($idea->shortlisted)
								<a class="shortlisted-banner" href="{{ action('IdeaController@index') }}">
									<i class="fa fa-fw fa-star"></i>
									<span class="shortlisted-text">{{ trans('common.shortlisted') }}</span>
								</a>
							@endif

						</div>

						@include('ideas/notification')

            @if (DynamicConfig::fetchConfig('PROGRESS_BAR_ENABLED', true))
  						@include('ideas/progress')
            @endif

		    			<p class="idea-description">
		    				{!! nl2br($idea->description) !!}
		    			</p>

						<ul class="category-pills">
							@foreach ($idea->categories as $category)

								<li class="category-pill">{{ $category->name }}</li>

							@endforeach
						</ul>

					</div>

	    			<div class="mobile-sidebar side-column hidden-md hidden-lg">

    					@include('ideas/side-column')

    				</div>

					@include('ideas/widgets/tenders')

					@include('ideas/widgets/proposals')

					@include('ideas/widgets/design-tasks')

					@unless((count($updates) == 0) && (Gate::denies('postUpdate', $idea)))

						<div class="section-header">
							<h2>{{ trans('idea.updates') }}</h2>
						</div>

						<div class="idea-section updates-section">

			    			@include('ideas/updates', ['updates' => $updates])

						</div>

					@endunless

					<div class="section-header">
						<h2>{{ trans('idea.discussion') }}</h2>
					</div>

					<div class="idea-section comments-section with-border">

						@include('discussion', ['target_id' => $idea->id, 'target_type' => 'Idea', 'idea_id' => $idea->id])

					</div>

	    		</div>

	    	</div>
	    </div>
	</div>

	@include('modals/supporters')

	@include('modals/support')

	@include('modals/open-design-phase', ['idea' => $idea])

	<?php Session::set('redirect', Request::url()); ?>

	<script type="text/javascript">

		var idea_id = '{{ $idea->id }}';
		var idea_name = '{{ $idea->name }}';
		var idea_url = '{{ url()->current() }}';
		var auth_type = '{{ Session::pull("auth_type") }}';
		var is_authorized = '{{ Auth::check() ? true : false }}';
		var show_support = '{{ Session::pull("show_support") ? true : false }}';

	</script>

	<script src="/js/ideas/view.js"></script>
	<script src="/js/ideas/update.js"></script>

@endsection
