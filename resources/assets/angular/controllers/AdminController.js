XMovement.controller('AdminController', function($scope, $http, $rootScope, $localStorage, $sessionStorage, AdminService, UserService) {

	$scope.current_view = '';

	$scope.user_search_results = [];
	$scope.original_user_search_results = [];

	$scope.admins = [];

	$scope.fetchAdmins = function() {

		UserService.getAdmins().then(function(response) {

			$scope.admins = response.data.users;

			// Remove existing admins from results
			$scope.user_search_results = _.filter($scope.original_user_search_results, function(result) {
				return !_.find($scope.admins, function(admin) {
					return admin.id === result.id;
				});
			});

		});
	}

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

	$scope.setCurrentView = function(current_view) {

		$scope.current_view = current_view;

	}

	// Fetch the current progression type
	AdminService.fetchConfig({key:'PROGRESSION_TYPE'}).then(function(response) {

		// Update UI with returned config value
		$scope.progression_type = response.data;

	});

	$rootScope.$on('AdminPermission::permissionsUpdated', function() {

		$scope.fetchAdmins();
	});

	$scope.searchUsers = function(user_search_query) {

		console.log("Loading users");

		$scope.user_search_results = [];

		$scope.searching_users = true;

		if (user_search_query.length > 1)
		{
			UserService.searchUsers({name:user_search_query}).then(function(response) {

				console.log(response);

				$scope.original_user_search_results = response.data.users;

				// Remove existing admins from results
				$scope.user_search_results = _.filter(response.data.users, function(result) {
					return !_.find($scope.admins, function(admin) {
				        return admin.id === result.id;
				    });
				});

				$scope.searching_users = false;

			});
		}
		else
		{
			$scope.searching_users = false;
		}
	}

	$scope.getProfileImage = function(user, size) {

		if (user.avatar == 'avatar')
		{
			return '/dynamic/avatar/' + size + '?name=' + encodeURIComponent(user.name);
		}
		else
		{
			return 'https://s3.amazonaws.com/xmovement/uploads/images/' + size + '/' + user.avatar;
		}
	}

	$scope.fetchAdmins();
});
