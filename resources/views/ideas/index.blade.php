@extends('layouts.app')

@section('content')

	<div class="page-header" ng-click="test()">

        <h2 class="main-title">{{ trans('pages.explore') }}</h2>

	</div>

	<div class="white-controls-row">

		<div class="container">

			<div class="view-controls-container">

    			<ul class="module-controls pull-left" ng-init="sort_type = 'created_at'">

					<li class="module-control" ng-click="sort_type = 'created_at'" ng-class="{'active':sort_type == 'created_at'}">

						<button type="button">{{ trans('idea.sort_recent') }}</button>

    				</li>

					<li class="module-control" ng-click="sort_type = 'supporter_count'" ng-class="{'active':sort_type == 'supporter_count'}">

						<button type="button">{{ trans('idea.sort_popular') }}</button>

    				</li>

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

    <div class="container ideas-container">

        <div class="row">

            <div class="col-xs-12 col-sm-6 col-md-3" ng-repeat="idea in ideas | orderBy:sort_type:true | filter:idea_search_term">

				<div class="tile idea-tile" ng-show="idea">
					<a class="tile-image" style="background-image:url('https://s3.amazonaws.com/xmovement/uploads/images/large/<% idea.photo %>')" ng-href="/idea/<% idea.id %>"></a>
					<div class="inner-container">
						<a class="idea-name" ng-href="/idea/<% idea.id %>">
						    <% idea.name | cut:true:50:'...' %>
						</a>
						<p class="idea-author">
							{{ trans('idea.posted_by') }} <a href="/profile/<% idea.user.id %>"><% idea.user.name %></a>
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


				No Results<span ng-show="idea_search_term.length > 0"> for <% idea_search_term %></span>

			</div>

        </div>

    </div>

@endsection
