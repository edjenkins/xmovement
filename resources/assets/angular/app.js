'use strict';

var underscore = angular.module('underscore', []);

underscore.factory('_', function() {
	return window._;
});

var XMovement = angular.module('XMovement', ['ngRoute', 'ngStorage', 'underscore', 'iso.directives', 'hj.imagesLoaded', 'angularMoment'], function($interpolateProvider) {
	$interpolateProvider.startSymbol('<%');
	$interpolateProvider.endSymbol('%>');
});

XMovement.config(function($routeProvider, $locationProvider) {

	// TODO: Issue causing digest infinte loop when html5 mode set to true
	$locationProvider.html5Mode(true);
});

XMovement.config(function($logProvider) {
	
    $logProvider.debugEnabled(true);
});

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
