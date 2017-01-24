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
					$scope.user.value = response.data;

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
