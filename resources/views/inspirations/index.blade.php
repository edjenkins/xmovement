@extends('layouts.app', ['bodyclasses' => 'medium-grey'])

@section('content')

	<div ng-controller="InspirationController" ng-cloak>

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

						<li class="module-control" ng-click="loadInspirations('favourites')" ng-class="{'active':sort_type == 'favourites'}">

							<button type="button">{{ trans('idea.sort_favourites') }}</button>

	    				</li>

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

					<div class="side-panel inspirations-side-panel">

						@can('create', App\Inspiration::class)
							<div class="side-panel-box submission-box">
								<div class="side-panel-box-header">
									Add Inspiration
								</div>
								<div class="side-panel-box-content" ng-init="submission_type = 'photo'">
									<ul class="submission-type-selector">
										<li ng-class="{'selected' : (submission_type == 'photo')}" ng-click="submission_type = 'photo'" onclick="setTimeout(function() { $('textarea').expanding() }, 100)"><i class="fa fa-camera"></i></li>
										<li ng-class="{'selected' : (submission_type == 'video')}" ng-click="submission_type = 'video'" onclick="setTimeout(function() { $('textarea').expanding() }, 100)"><i class="fa fa-video-camera"></i></li>
										<li ng-class="{'selected' : (submission_type == 'file')}" ng-click="submission_type = 'file'" onclick="setTimeout(function() { $('textarea').expanding() }, 100)"><i class="fa fa-file-text-o"></i></li>
										<li ng-class="{'selected' : (submission_type == 'link')}" ng-click="submission_type = 'link'" onclick="setTimeout(function() { $('textarea').expanding() }, 100)"><i class="fa fa-link"></i></li>
									</ul>

									<form class="" action="index.html" method="post" ng-show="submission_type == 'photo'">
										<div class="input-wrapper">
											@include('dropzone', ['type' => 'image', 'cc' => false, 'input_id' => 'dropzone-photo', 'value' => old('photo'), 'dropzone_id' => 1])
										</div>
										<div class="input-wrapper">
											<textarea class="expanding" rows="1" ng-model="new_inspiration['photo'].description" cols="40" placeholder="Photo Description"></textarea>
										</div>
										@foreach ($inspiration_categories as $inspiration_category)
											<label style="font-size: 13px; margin: 0px 5px 15px 5px;">
												<input type="radio" ng-model="new_inspiration['photo'].category" value="{{ $inspiration_category->id }}">
												{{ $inspiration_category->name }}
											</label>
										@endforeach
										<button ng-click="addInspiration('photo')" class="btn" type="button" name="button">Share Photo</button>
									</form>

									<form class="" action="index.html" method="post" ng-show="submission_type == 'video'">
										<div class="input-wrapper">
											<textarea class="expanding" rows="1" ng-model="new_inspiration['video'].content" cols="40" placeholder="YouTube URL"></textarea>
										</div>
										<div class="input-wrapper">
											<textarea class="expanding" rows="1" ng-model="new_inspiration['video'].description" cols="40" placeholder="Video Description"></textarea>
										</div>
										<button ng-click="addInspiration('video')" class="btn" type="button" name="button">Share Video</button>
									</form>

									<form class="" action="index.html" method="post" ng-show="submission_type == 'file'">
										<div class="input-wrapper">
											@include('dropzone', ['type' => 'file', 'cc' => false, 'input_id' => 'dropzone-file', 'value' => old('file'), 'dropzone_id' => 2])
										</div>
										<div class="input-wrapper">
											<textarea class="expanding" rows="1" ng-model="new_inspiration['file'].description" cols="40" placeholder="File Description"></textarea>
										</div>
										<button ng-click="addInspiration('file')" class="btn" type="button" name="button">Share File</button>
									</form>

									<form class="" action="index.html" method="post" ng-show="submission_type == 'link'">
										<div class="input-wrapper">
											<textarea class="expanding" rows="1" ng-model="new_inspiration['link'].content" cols="40" placeholder="Link URL"></textarea>
										</div>
										<div class="input-wrapper">
											<textarea class="expanding" rows="1" ng-model="new_inspiration['link'].description" cols="40" placeholder="Link Description"></textarea>
										</div>
										<button ng-click="addInspiration('link')" class="btn" type="button" name="button">Share Link</button>
									</form>
								</div>
							</div>
						@endcan

						<div class="side-panel-box info-box">
							<div class="side-panel-box-header">
								Competition Guidelines
							</div>
							<div class="side-panel-box-content">
								<p>
									Please be sure to read our simple competition guidelines before getting involved.
								</p>
								<a href="/guidelines" target="_self"><button class="btn" type="button" name="button">Read Guidelines</button></a>
							</div>
						</div>

					</div>

				</div>

				<div class="col-sm-8 col-md-9 col-sm-pull-4 col-md-pull-3">

					<div class="loader" ng-show="loading_inspirations">Loading...</div>

				</div>

				<div ng-cloak isotope-container="isotope-container" id="isotopeContainer" isotope-container data-isotope='{ "transitionDuration": "0.2s" }' class="isotope col-sm-8 col-md-9 col-sm-pull-4 col-md-pull-3">

					<div ng-cloak isotope-item="isotope-item" class="tile inspiration-tile isotope-item images-loaded" ng-repeat="inspiration in inspirations" ng-show="(sort_type != 'favourites') || (inspiration.has_favourited && (sort_type == 'favourites'))" ng-click="openInspirationModal(inspiration)">

						<div class="inspiration-categories">
							<ul>
								<li ng-repeat="category in inspiration.categories">
									<i class="fa fa-tag fa-fw"></i> <% category.name %>
								</li>
							</ul>
						</div>

						<img ng-if="inspiration.type == 'photo'" class="photo-tile-image" ng-src="<% inspiration.content.indexOf('http') == 0) ? inspiration.content : 'https://s3.amazonaws.com/xmovement/uploads/images/large/' + inspiration.content %>"></img>

						https://s3.amazonaws.com/xmovement/uploads/images/medium/<% inspiration.content %>

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
