@extends('layouts.app', ['bodyclasses' => 'grey'])

@section('content')

	<div ng-controller="TranslationController" ng-cloak>

		<div class="page-header">

	        <h2 class="main-title">Translate</h2>

		</div>

		<div class="white-controls-row">

			<div class="container-fluid">

				<div class="view-controls-container">

				<ul class="module-controls pull-left">

					<li class="module-control search-element">
						<div id="search-button">
							<i class="fa fa-search"></i>
						</div>
					</li>

					<li class="module-control search-element" ng-init="translation_search_term = ''">
						<input type="text" ng-model="translation_search_term" placeholder="Search Translations">
					</li>

				</ul>

	    			<ul class="module-controls pull-right">

						<li class="module-control" ng-click="findTranslations($event)">

							<button type="button">Find</button>

	    				</li>

						<li class="module-control" ng-click="importTranslations($event)">

							<button type="button">Import</button>

	    				</li>

						<li class="module-control" ng-click="exportAllTranslations($event)">

							<button type="button">Export</button>

	    				</li>

	    			</ul>

	    			<div class="clearfloat"></div>

	    		</div>

			</div>

		</div>

        <div class="container-fluid translations-container">

			<div class="row">

	            <ul>

					<li class="translation">
						<ul class="translation-row">
							<li class="translation-key-header">
								Key
							</li>
							<li class="translation-value-header">
								English
							</li>
							<div class="clearfloat"></div>
						</ul>
					</li>

					<li class="translation" ng-repeat="translation in translations | orderBy:'en.group' | filter:translation_search_term">

						<ul class="translation-row">

							<li class="translation-state" ng-init="translation.en.state = (translation.en.state) ? translation.en.state : (translation.en.value ? 'updated' : 'empty')">
								<i class="fa fa-check-circle" ng-show="translation.en.state == 'updated'"></i>
								<i class="fa fa-refresh fa-spin" ng-show="translation.en.state == 'loading'"></i>
								<i class="fa fa-exclamation-triangle" ng-show="translation.en.state == 'empty'"></i>
							</li>

							<li class="translation-key">
								<span class="translation-group"><% translation.en.group + '.' %></span><span><% translation.en.key %></span>
							</li>

							<li class="translation-value" ng-init="translation.en.original = (translation.en.original) ? translation.en.original : translation.en.value">
								<textarea class="expanding" name="value" placeholder="Enter translation" rows="1" cols="40" ng-model="translation.en.original" onfocus="$(this).expanding()" ng-blur="updateTranslation(translation.en)"></textarea>
							</li>

							<div class="clearfloat"></div>

						</ul>

					</li>

	            </ul>

			</div>

        </div>

	</div>

	<script src="{{ URL::asset('js/angular-dependencies.js') }}"></script>
	<script src="{{ URL::asset('js/masonry.js') }}"></script>
	<script src="{{ URL::asset('js/angular.js') }}"></script>

@endsection
