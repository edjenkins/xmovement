'use strict';

var XMovement = angular.module('XMovement', ['ngRoute'], function($interpolateProvider) {
	$interpolateProvider.startSymbol('<%');
	$interpolateProvider.endSymbol('%>');
})

XMovement.service('ExploreService', function($http, $q) {
	return {
		'getIdeas': function() {
			var defer = $q.defer();
			$http.get('/api/ideas').success(function(resp){
				defer.resolve(resp);
			}).error( function(err) {
				defer.reject(err);
			});
			return defer.promise;
		}
	}})

XMovement.service('TranslationService', function($http, $q) {
	return {
		'getTranslations': function() {
			var defer = $q.defer();
			$http.get('/api/translations').success(function(resp){
				defer.resolve(resp);
			}).error( function(err) {
				defer.reject(err);
			});
			return defer.promise;
		},
		'updateTranslation': function(body) {
			var defer = $q.defer();
			$http.post('/api/translation/update', body).success(function(resp){
				defer.resolve(resp);
			}).error( function(err) {
				defer.reject(err);
			});
			return defer.promise;
		},
		'exportAllTranslations': function() {
			var defer = $q.defer();
			$http.get('/api/translations/export').success(function(resp){
				defer.resolve(resp);
			}).error( function(err) {
				defer.reject(err);
			});
			return defer.promise;
		}

	}})

XMovement.filter('cut', function () {
	return function (value, wordwise, max, tail) {
		if (!value) return '';

		max = parseInt(max, 10);
		if (!max) return value;
		if (value.length <= max) return value;

		value = value.substr(0, max);
		if (wordwise) {
			var lastspace = value.lastIndexOf(' ');
			if (lastspace != -1) {
				//Also remove . and , so its gives a cleaner result.
				if (value.charAt(lastspace-1) == '.' || value.charAt(lastspace-1) == ',') {
					lastspace = lastspace - 1;
				}
				value = value.substr(0, lastspace);
			}
		}

		return value + (tail || ' …');
	};
});

XMovement.controller('ExploreController', function($scope, $http, $rootScope, ExploreService) {

	$scope.ideas = [];

	$scope.getIdeas = function() {

		console.log("Loading ideas");

		ExploreService.getIdeas().then(function(response) {

			console.log(response);

			$scope.ideas = response.data.ideas;

		});
	}

	$scope.getIdeas();

});

XMovement.controller('TranslationController', function($scope, $http, $rootScope, TranslationService) {

	$scope.translations = [];

	$scope.getTranslations = function() {

		console.log("Loading translations");

		$scope.translations = [];

		TranslationService.getTranslations().then(function(response) {

			console.log(response);

			$scope.translations = response.data.translations;

			setTimeout(function() { $('textarea').expanding(); }, 500);

		});
	}

	$scope.updateTranslation = function(translation) {

		console.log('Updating translation');

		translation.state = 'loading';

		TranslationService.updateTranslation({ translation : translation }).then(function(response) {

			setTimeout(function() { translation.state = 'updated'; }, 500);

			console.log(response);

		});
	}

	$scope.exportAllTranslations = function() {

		console.log('Exporting all translations');

		TranslationService.exportAllTranslations().then(function(response) {

			console.log(response);

		});
	}

	$scope.getTranslations();

});
