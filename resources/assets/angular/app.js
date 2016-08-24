'use strict';

var underscore = angular.module('underscore', []);

underscore.factory('_', function() {
	return window._;
});

var XMovement = angular.module('XMovement', ['ngRoute', 'ngStorage', 'underscore', 'wu.masonry'], function($interpolateProvider) {
	$interpolateProvider.startSymbol('<%');
	$interpolateProvider.endSymbol('%>');
})

XMovement.config(['$locationProvider',

	function($locationProvider) {
		$locationProvider.html5Mode(false);
	}

]);

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
