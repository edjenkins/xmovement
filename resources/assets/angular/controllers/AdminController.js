XMovement.controller('AdminController', function($scope, $http, $rootScope, $localStorage, $sessionStorage, AdminService) {

	$scope.setProgressionType = function(progression_type) {

		$scope.progression_type = progression_type;

		// Update progression_type on server
		var data = {key:'PROGRESSION_TYPE', value:progression_type, type:'string'};

		AdminService.updateConfig(data).then(function(response) {

			$scope.progression_type = response.data;

			$rootScope.$broadcast('PhaseTimeline::updatePhases');

		});

		$rootScope.$broadcast('PhaseTimeline::updatePhases');
	}

	$scope.$storage = $localStorage.$default({
		current_view: 'general'
	});

	// TODO: Fetch all users with admin privileges
	$scope.users = [
		{ id: 1 }
	];

	$scope.setCurrentView = function(current_view) {

		$scope.$storage['current_view'] = current_view;

	}

	$scope.setCurrentView($scope.$storage['current_view']);

	// Fetch the current progression type
	AdminService.fetchConfig({key:'PROGRESSION_TYPE'}).then(function(response) {

		// Update UI with returned config value
		$scope.progression_type = response.data;

	});

});
