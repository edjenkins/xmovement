XMovement.controller('AdminController', function($scope, $http, $rootScope, $localStorage, $sessionStorage, AdminService) {

	$scope.$storage = $localStorage.$default({
		current_view: 'general'
	});

	$scope.users = [{id:1}, {id:2}];

	$scope.setCurrentView = function(current_view) {

		$scope.$storage['current_view'] = current_view;

	}

	$scope.setCurrentView($scope.$storage['current_view']);

});
