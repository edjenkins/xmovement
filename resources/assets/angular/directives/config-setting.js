XMovement.directive('xmConfigSetting', ['$document', '$rootScope', '$filter', '$timeout', 'AdminService', function($document, $rootScope, $filter, $timeout, AdminService) {
	return {
		restrict: 'AE',
		templateUrl: '/directives/config-setting',
		scope: {
			config: '=xmConfig',
			phaseTimelineCtrl: '=xmPhaseTimelineCtrl'
		},
		controllerAs: 'configController',
		controller: ['$rootScope', '$scope', function($rootScope, $scope) {

			var ConfigController = this;

			this.updateConfig = function($event) {

				var data = {key:$scope.config.key, value:$scope.config.value, type:$scope.config.type};

				AdminService.updateConfig(data).then(function(response) {

					// Update UI with returned config value
					$scope.config.value = response.data;

					$rootScope.$broadcast('PhaseTimeline::updatePhases');

				});
			}

			this.fetchConfig = function() {

				console.log('Fetching configuration - ' + $scope.config.key);

				AdminService.fetchConfig({key:$scope.config.key}).then(function(response) {

					// Update UI with returned config value
					$scope.config.value = response.data;

				});
			}

			this.fetchConfig();

		}]
	};
}]);
