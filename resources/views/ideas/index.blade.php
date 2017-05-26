@extends('layouts.app', ['bodyclasses' => (DynamicConfig::fetchConfig('EXPLORE_PHASE_LOCKED', false)) ? 'colorful' : 'medium-grey'])

@section('content')

	<div ng-controller="ExploreController">

		@if(DynamicConfig::fetchConfig('EXPLORE_PHASE_LOCKED', false))

			<div class="page-header">

		        <h2 class="main-title">{{ trans('common.comingsoon') }}</h2>

			</div>

			@include('deployment/components/ideas/comingsoon')

		@else

			<div class="page-header">

		        <h2 class="main-title">{{ trans('pages.explore') }}</h2>

			</div>

			<div class="white-controls-row">

				<div class="container">

					<div class="view-controls-container">

		    			<ul class="module-controls" ng-init="sort_type = '{{ DynamicConfig::fetchConfig('SHORTLIST_MODE_ENABLED', false) ? 'shortlist' : 'popular' }}'">

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

							<li class="module-control" ng-if="sort_type != 'shortlist'">

								<category-picker populated-only="false"></category-picker>

							</li>

							<li class="module-control search-element pull-right" ng-class="{'open':search_open}">
								<div class="search-bar" ng-init="idea_search_term = ''">
									<input type="text" ng-model="idea_search_term" placeholder="{{ trans('placeholders.search_ideas') }}">
								</div>
								<div id="search-button" ng-click="search_open = !search_open">
									<i class="fa fa-search"></i>
								</div>
							</li>

						</ul>

		    			<div class="clearfloat"></div>

		    		</div>

				</div>

			</div>

			<div class="container">

				<div class="info-message shortlist-info-message" ng-cloak ng-show="sort_type == 'shortlist'">
					<p>
						{{ trans('idea.shortlist_message') }}
					</p>
				</div>

			</div>

		    <div class="container ideas-container">

		        <div class="row">

					<div class="col-xs-12 col-sm-4 <% (sort_type == 'shortlist') ? 'col-md-4' : 'col-md-3' %>" ng-repeat="idea in ideas | orderBy:sort_order:true | filter:idea_search_term" ng-cloak>

						<div class="tile idea-tile">

							<div class="shortlisted-banner" ng-show="idea.shortlisted == 1" ng-click="setSortType('shortlist')">
								<i class="fa fa-fw fa-star"></i>
								<span class="shortlisted-text">shortlisted</span>
							</div>

							<a target="_self" class="tile-image" style="background-image:url('https://s3.amazonaws.com/xmovement/uploads/images/large/<% idea.photo %>')" ng-href="/idea/<% idea.id %>"></a>
							<div class="inner-container">
								<a target="_self" class="idea-name" ng-href="/idea/<% idea.id %>">
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
								<p>
									<% idea.latest_phase %>
								</p>
							</div>
						</div>

		            </div>

					<div class="col-xs-12 no-results" ng-show="(ideas | filter:idea_search_term).length == 0">

						<span ng-show="loading_ideas">{{ trans('common.loading') }}</span>

						<span ng-hide="loading_ideas" ng-cloak>
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

		@endif

	</div>

	<script src="{{ URL::asset('js/angular-dependencies.js') }}"></script>
	<script src="{{ URL::asset('js/angular.js') }}"></script>

@endsection
