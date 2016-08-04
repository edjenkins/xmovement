@extends('layouts.app', ['bodyclasses' => 'grey'])

@section('content')

	<div ng-controller="AnalyticsController" ng-cloak>

		<div class="page-header">

	        <h2 class="main-title">Analytics</h2>

		</div>

		<div class="white-controls-row">

			<div class="container">

				<div class="view-controls-container">

	    			<ul class="module-controls pull-left">

						<li class="module-control" ng-class="{'active' : ($storage.analytics_type == 'overview')}" ng-click="setAnalyticsType('overview')">

							<button type="button">Overview</button>

	    				</li>

						<li class="module-control" ng-class="{'active' : ($storage.analytics_type == 'users')}" ng-click="setAnalyticsType('users')">

							<button type="button">Users</button>

	    				</li>

						<li class="module-control" ng-class="{'active' : ($storage.analytics_type == 'ideas')}" ng-click="setAnalyticsType('ideas')">

							<button type="button">Ideas</button>

	    				</li>

	    			</ul>

	    			<div class="clearfloat"></div>

	    		</div>

			</div>

		</div>

        <div class="container analytics-container" ng-switch="$storage.analytics_type">

			@include('analytics/panels/overview')

			@include('analytics/panels/users')

			@include('analytics/panels/ideas')

        </div>

	</div>

@endsection
