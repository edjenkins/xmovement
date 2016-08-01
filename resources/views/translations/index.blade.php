@extends('layouts.app', ['bodyclasses' => 'grey'])

@section('content')

	<div ng-controller="TranslationController" ng-cloak>

		<div class="page-header">

	        <h2 class="main-title">Translate</h2>

		</div>

		<div class="white-controls-row">

			<div class="container">

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

						<li class="module-control" ng-click="getTranslations()">

							<button type="button">Reload</button>

	    				</li>

						<li class="module-control" ng-click="exportAllTranslations()">

							<button type="button">Export</button>

	    				</li>

	    			</ul>

	    			<div class="clearfloat"></div>

	    		</div>

			</div>

		</div>

        <div class="container translations-container">

			<div class="row">

	            <ul ng-repeat="translation in translations | filter:translation_search_term">

					<li class="translation">

						<ul class="translation-row">

							<li class="translation-state" ng-init="translation.state = (translation.state) ? translation.state : (translation.value ? 'updated' : 'empty')">
								<i class="fa fa-check-circle" ng-show="translation.state == 'updated'"></i>
								<i class="fa fa-refresh fa-spin" ng-show="translation.state == 'loading'"></i>
								<i class="fa fa-exclamation-triangle" ng-show="translation.state == 'empty'"></i>
							</li>

							<li class="translation-key">
								<span class="translation-group"><% translation.group + '.' %></span><span><% translation.key %></span>
							</li>

							<li class="translation-value">
								<textarea class="expanding" name="value" placeholder="Enter translation" rows="1" cols="40" ng-model="translation.value" ng-blur="updateTranslation(translation)"></textarea>
							</li>

							<div class="clearfloat"></div>

						</ul>

					</li>

	            </ul>

			</div>

        </div>

	</div>

@endsection
