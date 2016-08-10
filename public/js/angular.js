'use strict';

var XMovement = angular.module('XMovement', ['ngRoute', 'ngStorage', 'wu.masonry'], function($interpolateProvider) {
	$interpolateProvider.startSymbol('<%');
	$interpolateProvider.endSymbol('%>');
})

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

XMovement.service('AnalyticsService', function($http, $q) {
	return {
		'getOverviewAnalytics': function() {
			var defer = $q.defer();
			$http.get('/api/analytics/overview').success(function(resp){
				defer.resolve(resp);
			}).error( function(err) {
				defer.reject(err);
			});
			return defer.promise;
		},
		'getUserAnalytics': function() {
			var defer = $q.defer();
			$http.get('/api/analytics/users').success(function(resp){
				defer.resolve(resp);
			}).error( function(err) {
				defer.reject(err);
			});
			return defer.promise;
		},
		'getIdeaAnalytics': function() {
			var defer = $q.defer();
			$http.get('/api/analytics/ideas').success(function(resp){
				defer.resolve(resp);
			}).error( function(err) {
				defer.reject(err);
			});
			return defer.promise;
		}
	}})

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

XMovement.service('InspirationService', function($http, $q) {
	return {
		'getInspirations': function() {
			var defer = $q.defer();
			$http.get('/api/inspirations').success(function(resp){
				defer.resolve(resp);
			}).error( function(err) {
				defer.reject(err);
			});
			return defer.promise;
		},
		'addInspiration': function(body) {
			var defer = $q.defer();
			$http.post('/api/inspiration/add', body).success(function(resp){
				defer.resolve(resp);
			}).error( function(err) {
				defer.reject(err);
			});
			return defer.promise;
		}
	}})

XMovement.service('TranslationService', function($http, $q) {
	return {
		'getTranslations': function(params) {
			var defer = $q.defer();
			$http({
			    url: '/api/translations',
			    method: "GET",
			    params: params
			 }).success(function(resp){
				defer.resolve(resp);
			}).error( function(err) {
				defer.reject(err);
			});
			return defer.promise;
		},
		'findTranslations': function(params) {
			var defer = $q.defer();
			$http({
			    url: '/api/translations/find',
			    method: "GET",
			    params: params
			 }).success(function(resp){
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

XMovement.controller('AnalyticsController', function($scope, $http, $rootScope, $localStorage, $sessionStorage, AnalyticsService) {

	$scope.$storage = $localStorage.$default({
		analytics_type: 'overview'
	});

	$scope.overview = [];
	$scope.users = [];
	$scope.ideas = [];

	$scope.headers = {
		users: [
			{name: 'Name', type: 'name'},
			{name: 'Email', type: 'email'},
			{name: 'Created', type: 'created_at'},
			{name: 'Ideas', type: 'ideas'},
			{name: 'Tasks', type: 'design_tasks'},
			{name: 'Votes', type: 'design_task_votes'},
			{name: 'Proposals', type: 'proposals'},
			{name: 'Comments', type: 'comments'},
		],
		ideas: [
			{name: 'Name', type: 'name'},
			{name: 'Creator', type: 'creator'},
			{name: 'Supporters', type: 'supporters'},
			{name: 'Proposals', type: 'proposals'},
			{name: 'Comments', type: 'comments'},
			{name: 'Duration', type: 'duration'},
			{name: 'Tasks', type: 'design_tasks'},
			{name: 'Progress', type: 'progress'},
			{name: 'Share Button Clicks', type: 'share_button_clicks'},
			{name: 'Created', type: 'created'},
		]
	};

	$scope.getOverviewAnalytics = function() {

		AnalyticsService.getOverviewAnalytics().then(function(response) {

			$scope.overview = response.data.overview;

		});

	}

	$scope.getUserAnalytics = function() {

		AnalyticsService.getUserAnalytics().then(function(response) {

			$scope.users = response.data.users;

		});
	}

	$scope.getIdeaAnalytics = function() {

		AnalyticsService.getIdeaAnalytics().then(function(response) {

			$scope.ideas = response.data.ideas;

			console.log(response.data.ideas[0]);

		});
	}

	$scope.toggleDetailRow = function(user, column) {

		user.visible_detail_row = (column == user.visible_detail_row) ? '' : column;

	}

	$scope.setAnalyticsType = function(analytics_type) {

		$scope.$storage['analytics_type'] = analytics_type;

		switch ($scope.$storage['analytics_type']) {
			case 'overview':
				$scope.getOverviewAnalytics();
				break;
			case 'users':
				$scope.getUserAnalytics();
				break;
			case 'ideas':
				$scope.getIdeaAnalytics();
				break;
			default:
				$scope.getOverviewAnalytics();
				break;
		}
	}

	$scope.setAnalyticsType($scope.$storage['analytics_type']);

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

XMovement.controller('InspirationController', function($scope, $http, $rootScope, $sce, InspirationService) {

	$scope.inspirations = [];
	$scope.selected_inspiration = {};
	$scope.new_inspiration =
	{
		photo: {type:'photo',title:'My Test Photo',description:'If you like tests then you will love this test photograph I never took, it was from the interwebs.',content:''},
		video: {type:'video',title:'My Test Video',description:'If you like tests then you will love this test video I never took, it was from the interwebs.',content:''},
		file: {type:'file',title:'My Test File',description:'If you like tests then you will love this test file I never took, it was from the interwebs.',content:''},
		link: {type:'link',title:'My Test Link',description:'If you like tests then you will love this test link I never took, it was from the interwebs.',content:''}
	};

	$scope.getInspirations = function() {

		console.log("Loading inspirations");

		InspirationService.getInspirations().then(function(response) {

			console.log(response);

			// TODO:
			// $scope.selected_inspiration = $scope.inspirations[0];

			$scope.inspirations = $scope.formatInspirations(response.data.inspirations);

			console.log($scope.inspirations);

			// $('#masonry-grid').masonry();

		});
	}

	$scope.addInspiration = function(type) {

		console.log("Adding inspiration");

		$scope.new_inspiration[type].type = type;

		InspirationService.addInspiration({inspiration: $scope.new_inspiration[type] }).then(function(response) {

			console.log(response);

			if (response.meta.success)
			{
				$scope.inspirations.unshift($scope.formatInspirations([response.data.inspiration])[0]);

				// $('#masonry-grid').imagesLoaded({ background: '.video-tile-image' }).always(function() {
				// 	$('#masonry-grid').masonry('reloadItems');
				// 	$('#masonry-grid').masonry('layout');
				// });

			}

		});
	}

	$scope.formatInspirations = function(inspirations) {

		for (var i = 0; i < inspirations.length; i++)
		{
			if (inspirations[i].type == 'video')
			{
				inspirations[i].content = JSON.parse(inspirations[i].content);
			}
		}

		return inspirations;

	}

	$scope.openInspirationModal = function(inspiration) {

		$scope.selected_inspiration = inspiration;

	}

	$scope.setIframeUrl = function(url) {

		return $sce.trustAsResourceUrl(url);
	}

	$scope.getInspirations();

});

XMovement.controller('TranslationController', function($scope, $http, $rootScope, $timeout, TranslationService) {

	$scope.translations = [];

	$scope.getTranslations = function() {

		console.log("Loading translations");

		$scope.translations = [];

		TranslationService.getTranslations({ override : false }).then(function(response) {

			console.log(response);

			$scope.translations = response.data.translations;

			setTimeout(function() { $('textarea').expanding(); }, 500);

		});
	}

	$scope.findTranslations = function($event) {

		console.log("Finding translations");

		$($event.target).html('Finding..');

		$timeout(function () {

			TranslationService.findTranslations().then(function(response) {

				console.log(response);

				$($event.target).html('Find');

				alert('Find complete');

			});

		}, 1000);
	}

	$scope.updateTranslation = function(translation) {

		console.log('Updating translation');

		translation.state = 'loading';

		translation.value = translation.original;

		TranslationService.updateTranslation({ translation : translation }).then(function(response) {

			translation.state = 'updated';

			console.log(response);

		});
	}

	$scope.importTranslations = function($event) {

		console.log("Importing translations");

		$($event.target).html('Importing..');

		$scope.translations = [];

		$timeout(function () {

			TranslationService.getTranslations({ override : true }).then(function(response) {

				console.log(response);

				$scope.translations = response.data.translations;

				setTimeout(function() { $('textarea').expanding(); }, 500);

				$($event.target).html('Import');

				alert('Import complete');

			});

		}, 1000);

	}

	$scope.exportAllTranslations = function($event) {

		console.log('Exporting all translations');

		$($event.target).html('Exporting..');

		$timeout(function () {

			TranslationService.exportAllTranslations().then(function(response) {

				console.log(response);

				$($event.target).html('Export');

				alert('Export complete');

			});

		}, 1000);

	}

	$scope.getTranslations();

});

//# sourceMappingURL=angular.js.map
