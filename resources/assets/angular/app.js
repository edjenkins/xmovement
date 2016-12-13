'use strict';

var underscore = angular.module('underscore', []);

underscore.factory('_', function() {
	return window._;
});

var XMovement = angular.module('XMovement', ['ngRoute', 'ngStorage', 'underscore', 'iso.directives', 'hj.imagesLoaded', 'angularMoment'], function($interpolateProvider) {
	$interpolateProvider.startSymbol('<%');
	$interpolateProvider.endSymbol('%>');
})

XMovement.config(function($routeProvider, $locationProvider) {

	// TODO: Issue causing digest infinte loop when html5 mode set to true
	$locationProvider.html5Mode(true);

});

XMovement.directive('xmConfigSetting', ['$document', '$rootScope', '$filter', '$timeout', 'AdminService', function($document, $rootScope, $filter, $timeout, AdminService) {
	return {
		restrict: 'AE',
		templateUrl: '/directives/config-setting',
		scope: {
			config: '=xmConfig'
		},
		controllerAs: 'configController',
		controller: ['$rootScope', '$scope', function($rootScope, $scope) {

			var ConfigController = this;

			this.updateConfig = function($event) {

				console.log($scope.config.value);

				var data = {key:$scope.config.key, value:$scope.config.value, type:$scope.config.type};

				console.log(data);

				AdminService.updateConfig(data).then(function(response) {

					// Update UI with returned config value
					$scope.config.value = response.data;

				});
			}

			this.fetchConfig = function() {

				console.log('Fetching configuration - ' + $scope.config.key);

				AdminService.fetchConfig({key:$scope.config.key}).then(function(response) {

					console.log(response);

					// Update UI with returned config value
					$scope.config.value = response.data;

				});
			}

			this.fetchConfig();

		}]
	};
}]);

XMovement.directive('xmConfigUser', ['$document', '$rootScope', '$filter', '$timeout', 'AdminService', function($document, $rootScope, $filter, $timeout, AdminService) {
	return {
		restrict: 'AE',
		templateUrl: '/directives/config-user',
		scope: {
			user: '=xmUser'
		},
		controllerAs: 'configController',
		controller: ['$rootScope', '$scope', function($rootScope, $scope) {

			var ConfigController = this;

			this.updatePermission = function($event, key) {

				var data = {user_id:$scope.user.id, key:key, value:$scope.user[key]};

				AdminService.updatePermission(data).then(function(response) {

					// Update UI with returned config value
					$scope.config.value = response.data;

				});
			}

			this.fetchPermission = function() {

				console.log('Fetching user permissions - ' + $scope.user.id);

				AdminService.fetchPermission({user_id:$scope.user.id}).then(function(response) {

					console.log(response);

					// Update UI with returned config value
					$scope.user = response.data;

				});
			}

			this.fetchPermission();

		}]
	};
}]);


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

XMovement.filter("trust", ['$sce', function($sce) {
  return function(htmlCode){
    return $sce.trustAsHtml(htmlCode);
  }
}]);
