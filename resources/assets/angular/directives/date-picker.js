XMovement.directive('xmDatePicker', ['$document', '$rootScope', '$filter', '$timeout', 'AdminService', function($document, $rootScope, $filter, $timeout, AdminService) {
	return {
		restrict: 'AE',
		templateUrl: '/directives/date-picker',
		scope: {
			date: '=xmDate',
			config: '=xmConfig',
			configController: '=xmConfigController'
		},
		controllerAs: 'ctrl',
		controller: ['$rootScope', '$scope', function($rootScope, $scope) {

			var ConfigController = this;

			this.dateSelected = function(element, val) {

				var data = {key:$scope.config.key, value:val, type:'timestamp'};

				AdminService.updateConfig(data).then(function(response) {

					console.log(response);
					// Update UI with returned config value
					$scope.date = response.data;

					$rootScope.$broadcast('PhaseTimeline::updatePhases');

				});
			}

		}],
		link: function($scope, element, attrs, ctrl) {

			var date_picker = $(element).find('.datepicker');

			date_picker.datepicker();
			date_picker.datepicker({ dateFormat: 'd M, y' });
			date_picker.change(function(val) {

				ctrl.dateSelected(element, $(this).datepicker("getDate"));
			});

		}
	};
}]);
