@extends('layouts.app', ['bodyclasses' => 'medium-grey'])

@section('content')

	<div ng-controller="ExploreController">

		<div class="page-header">

	        <h2 class="main-title">{{ trans('pages.explore') }}</h2>

		</div>

		<div class="white-controls-row">

			<div class="container">

				<div class="view-controls-container">

	    			<ul class="module-controls pull-left" ng-init="sort_type = '{{ DynamicConfig::fetchConfig('SHORTLIST_MODE_ENABLED', false) ? 'shortlist' : 'popular' }}'">

						<li class="module-control" ng-click="setSortType('popular')" ng-class="{'active':sort_type == 'popular'}">

							<button type="button">{{ trans('idea.sort_popular') }}</button>

	    				</li>

						<li class="module-control" ng-click="setSortType('recent')" ng-class="{'active':sort_type == 'recent'}">

							<button type="button">{{ trans('idea.sort_recent') }}</button>

	    				</li>

						@if(DynamicConfig::fetchConfig('SHORTLIST_MODE_ENABLED', false))
							<li class="module-control" ng-click="setSortType('shortlist')" ng-class="{'active':sort_type == 'shortlist'}">

								<button type="button">{{ trans('idea.sort_shortlist') }}</button>

		    				</li>
						@endif

	    			</ul>

					<ul class="module-controls pull-right">

						<li class="module-control search-element">
							<div id="search-button">
								<i class="fa fa-search"></i>
							</div>
						</li>

						<li class="module-control search-element" ng-init="idea_search_term = ''">
							<input type="text" ng-model="idea_search_term" placeholder="{{ trans('placeholders.search_ideas') }}">
						</li>

					</ul>

	    			<div class="clearfloat"></div>

	    		</div>

			</div>

		</div>

		<div class="container">

			<div class="shortlist-info-box" ng-show="sort_type == 'shortlist'">
				<p>
					{{ trans('idea.shortlist_message') }}
				</p>
			</div>

		</div>

	    <div class="container ideas-container">

	        <div class="row">

				<div class="col-xs-12 col-sm-6 <% (sort_type == 'shortlist') ? 'col-md-4' : 'col-md-3' %>" ng-repeat="idea in ideas | orderBy:sort_order:true | filter:idea_search_term">

					<div class="tile idea-tile">

						<div class="shortlisted-banner" ng-show="idea.shortlisted == 1" ng-click="setSortType('shortlist')">
							<i class="fa fa-fw fa-star"></i>
							<span class="shortlisted-text">shortlisted</span>
						</div>

						<a class="tile-image" style="background-image:url('https://s3.amazonaws.com/xmovement/uploads/images/large/<% idea.photo %>')" ng-href="/idea/<% idea.id %>"></a>
						<div class="inner-container">
							<a class="idea-name" ng-href="/idea/<% idea.id %>">
							    <% idea.name | cut:true:50:'...' %>
							</a>
							<p class="idea-author">
								{{ trans('idea.posted_by') }} <a target="_self" href="/profile/<% idea.user.id %>"><% idea.user.name %></a>
							</p>
							<p class="idea-description">
								<% idea.description | cut:true:100:'...' %>
							</p>
						</div>
						<div class="tile-footer">
							<div class="phase-progress" style="right:<% (100 - idea.progress) %>%"></div>
							<p>
								<% idea.latest_phase %>
							</p>
						</div>
					</div>

	            </div>

				<div class="col-xs-12 no-results" ng-show="(ideas | filter:idea_search_term).length == 0">

					<span ng-show="loading_ideas">{{ trans('common.loading') }}</span>

					<span ng-hide="loading_ideas">
						<span ng-show="idea_search_term.length > 0">
							{{ trans('common.no_results_for_x') }} <% idea_search_term %>
						</span>
						<span ng-hide="idea_search_term.length > 0">
							{{ trans('common.no_results') }}
						</span>
					</span>

				</div>

	        </div>

	    </div>

	</div>

	<script src="{{ URL::asset('js/angular-dependencies.js') }}"></script>
	<script src="{{ URL::asset('js/angular.js') }}"></script>

@endsection
