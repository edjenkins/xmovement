@extends('layouts.app', ['bodyclasses' => 'grey'])

@section('content')

	<div ng-controller="AdminController" ng-cloak ng-init="available_views = ['permissions']; setCurrentView(available_views[0])">

		<div class="page-header">

	        <h2 class="main-title">{{ trans('admin.admin_management') }}</h2>

		</div>

        <div class="container admin-container" ng-switch="current_view">

			@can('manage_admins', Auth::user())
				@include('admin/management/panels/permissions')
			@endcan

        </div>

	</div>

	<script src="{{ URL::asset('js/angular-dependencies.js') }}"></script>
	<script src="{{ URL::asset('js/angular.js') }}"></script>

@endsection
