@extends('layouts.app', ['bodyclasses' => 'white'])

@section('content')

	<div ng-controller="CreateIdeaController">

	    <div class="page-header">

	        <h2 class="main-title" id="page-title">{{ $errors->isEmpty() ? trans('idea_form.name_your_idea') : trans('idea_form.edit_idea') }}</h2>

	    </div>

	    <div class="container">
	        <div class="row">
	            <div class="col-md-8 col-md-offset-2">

	                @include('forms/idea/add', ['editing' => true])

	            </div>
	        </div>
	    </div>

	</div>

    <script src="/js/ideas/add.js"></script>

	<script src="{{ URL::asset('js/angular-dependencies.js') }}"></script>
	<script src="{{ URL::asset('js/angular.js') }}"></script>

@endsection
