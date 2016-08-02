'use strict';

var XMovement = angular.module('XMovement', ['ngRoute', 'wu.masonry'], function($interpolateProvider) {
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

		XMovement.controller('InspirationController', function($scope, $http, $rootScope, $sce, InspirationService) {

			$scope.inspirations = [];
			$scope.selected_inspiration = {};
			$scope.inspiration =
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

					$scope.inspirations = response.data.inspirations;

					// TODO:
					// $scope.selected_inspiration = $scope.inspirations[0];

					$scope.inspirations = $scope.formatInspirations($scope.inspirations);

				});
			}

			$scope.addInspiration = function(type) {

				console.log("Adding inspiration");

				$scope.inspiration[type].type = type;

				InspirationService.addInspiration({inspiration: $scope.inspiration[type] }).then(function(response) {

					console.log(response);

					if (response.meta.success)
					{
						$scope.inspirations.push($scope.formatInspirations([response.data.inspiration])[0]);

						$('#masonry-grid').imagesLoaded({ background: '.video-tile-image' }).always(function() {
							$('#masonry-grid').masonry('reloadItems');
							$('#masonry-grid').masonry('layout');
						});

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
