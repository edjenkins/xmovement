XMovement.directive('xmDatePicker', ['$document', '$rootScope', '$filter', '$timeout', function($document, $rootScope, $filter, $timeout) {
	return {
		restrict: 'AE',
		templateUrl: '/directives/date-picker',
		scope: {
			date: '=xmDate',
			configController: '=xmConfigController'
			// identifier: '=xmIdentifier',
			// phaseTimelineCtrl: '=xmPhaseTimelineCtrl'
		},
		controllerAs: 'ctrl',
		controller: ['$rootScope', '$scope', function($rootScope, $scope) {

			var ConfigController = this;

			this.dateSelected = function(element, val) {

				// $scope.date = val;
				// $scope.configController.updateConfig();



				var data = {key:'PROCESS_START_DATE', value:val, type:'timestamp'};

				AdminService.updateConfig(data).then(function(response) {

					// Update UI with returned config value
					// $scope.config.value = response.data;
					//
					// $rootScope.$broadcast('PhaseTimeline::updatePhases');

				});


				console.log('Date selected');
				console.log(val);
				// $scope.phaseTimelineCtrl.updatePhases();
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
