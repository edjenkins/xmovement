@extends('layouts.app', ['bodyclasses' => 'medium-grey'])

@section('content')

	<div ng-controller="InspirationController">

		<div class="page-header">

	        <h2 class="main-title">{{ trans('pages.inspiration') }}</h2>

		</div>

		<div class="white-controls-row">

			<div class="container inspirations-container">

				<div class="view-controls-container">

	    			<ul class="module-controls pull-left" ng-init="sort_type = 'popular'">

						<li class="module-control" ng-click="loadInspirations('popular')" ng-class="{'active':sort_type == 'popular'}">

							<button type="button">{{ trans('idea.sort_popular') }}</button>

	    				</li>

							<li class="module-control" ng-click="loadInspirations('recent')" ng-class="{'active':sort_type == 'recent'}">

								<button type="button">{{ trans('idea.sort_recent') }}</button>

		    				</li>

						@unless (Auth::guest())
							<li class="module-control" ng-click="loadInspirations('favourites')" ng-class="{'active':sort_type == 'favourites'}">

								<button type="button">{{ trans('idea.sort_favourites') }}</button>

		    				</li>
						@endunless

	    			</ul>

	    			<ul class="module-controls pull-right" ng-init="filter_type = 'none'">

						@foreach ($inspiration_categories as $inspiration_category)
							<li class="module-control" ng-click="filter_type = '{{ $inspiration_category->name }}'" ng-class="{'active':filter_type == '{{ $inspiration_category->name }}'}">

								<button type="button">
									<i class="fa fa-tag"></i>
									{{ $inspiration_category->name }}
								</button>

		    				</li>
						@endforeach

	    			</ul>

	    			<div class="clearfloat"></div>

	    		</div>

			</div>

		</div>

	    <div class="container inspirations-container">

	        <div class="row">

				<div class="col-sm-4 col-md-3 col-sm-push-8 col-md-push-9">

					<div class="side-panel inspirations-side-panel" ng-cloak>

						@include('inspirations/add')

						<div class="side-panel-box info-box">
							<div class="side-panel-box-header">
								Competition Guidelines
							</div>
							<div class="side-panel-box-content">
								<p>
									Please be sure to read our simple competition guidelines before getting involved.
								</p>
								<a target="_self" href="/guidelines" target="_self"><button class="btn" type="button" name="button">Read Guidelines</button></a>
							</div>
						</div>

					</div>

				</div>

				<div class="col-sm-8 col-md-9 col-sm-pull-4 col-md-pull-3">

					<div class="loader" ng-show="loading_inspirations">Loading...</div>

				</div>

				<div isotope-container="isotope-container" id="isotopeContainer" isotope-container data-isotope='{ "animationOptions": { "duration": "0.15"} }' class="isotope col-sm-8 col-md-9 col-sm-pull-4 col-md-pull-3">

					<div ng-cloak isotope-item="isotope-item" class="tile inspiration-tile isotope-item images-loaded animated fadeIn" ng-repeat="inspiration in inspirations track by $index" ng-if="(sort_type != 'favourites') || (inspiration.has_favourited && (sort_type == 'favourites'))" ng-click="openInspirationModal(inspiration)">

						<div class="inspiration-categories">
							<ul>
								<li ng-repeat="category in inspiration.categories">
									<i class="fa fa-tag fa-fw"></i> <% category.name %>
								</li>
							</ul>
						</div>

						<div ng-if="inspiration.type == 'photo'" class="photo-tile-image" ng-style="{'padding-bottom': (( inspiration.content.height / inspiration.content.width) * 100) + '%', 'background-image': 'url(' + 'https://s3.amazonaws.com/xmovement/uploads/images/large/' + inspiration.content.thumbnail + ')'}" data-file-height="<% inspiration.content.height %>" data-file-width="<% inspiration.content.width %>"></div>

						<div ng-if="inspiration.type == 'video'" class="video-tile-image" style="background-image:url('<% inspiration.content.thumbnail %>')">
							<i class="fa fa-play"></i>
						</div>

						<div ng-if="inspiration.type == 'file'" class="file-tile-icon">
							<i class="fa fa-file-text-o"></i>
						</div>

						<div ng-if="inspiration.type == 'link'" class="link-tile-icon">
							<i class="fa fa-link"></i>
						</div>

						<div class="inner-container">
							<p class="inspiration-description">
								<% inspiration.short_description %>
							</p>
						</div>

						<div class="inspiration-tile-footer">
							<p class="inspiration-author">
								<% inspiration.user.name %>
							</p>
							<p class="inspiration-favourties" ng-class="{ 'favourited' : inspiration.has_favourited }">
								<% inspiration.favourited_count %> <i class="fa fa-fw" ng-class="inspiration.favouriting ? 'fa-spinner fa-pulse' : 'fa-star'"></i>
							</p>
						</div>
					</div>

				</div>

	        </div>

	    </div>

		@include('modals/inspiration')

	</div>

	<script src="{{ URL::asset('js/angular-dependencies.js') }}"></script>
	<script src="{{ URL::asset('js/angular.js') }}"></script>

@endsection
