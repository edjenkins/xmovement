@extends('layouts.app', ['bodyclasses' => 'grey'])

@section('content')

	<div ng-controller="AdminController" ng-cloak ng-init="available_views = ['general', 'state']; setCurrentView(available_views[0])">

		<div class="page-header">

	        <h2 class="main-title">{{ trans('admin.platform_management') }}</h2>

		</div>

		<div class="white-controls-row">

			<div class="container">

				<div class="view-controls-container">

	    			<ul class="module-controls pull-left">

						@can('manage_platform', Auth::user())
							<li class="module-control" ng-class="{'active' : (current_view == 'general')}" ng-click="setCurrentView('general')">

								<button type="button">{{ trans('admin.view_general') }}</button>

		    				</li>

							<li class="module-control" ng-class="{'active' : (current_view == 'state')}" ng-click="setCurrentView('state')">

								<button type="button">{{ trans('admin.view_state') }}</button>

		    				</li>

							<li class="module-control" ng-class="{'active' : (current_view == 'categories')}" ng-click="setCurrentView('categories')">

								<button type="button">{{ trans('admin.view_categories') }}</button>

		    				</li>
						@endcan

	    			</ul>

	    			<div class="clearfloat"></div>

	    		</div>

			</div>

		</div>

        <div class="container admin-container" ng-switch="current_view">

			@can('manage_platform', Auth::user())
				@include('admin/management/panels/general')
				@include('admin/management/panels/state')
				@include('admin/management/panels/categories')
			@endcan

        </div>

	</div>

	<script src="{{ URL::asset('js/angular-dependencies.js') }}"></script>
	<script src="{{ URL::asset('js/angular.js') }}"></script>

@endsection
