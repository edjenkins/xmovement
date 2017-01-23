function dateDiffInDays(a, b) {

  var utc1 = Date.UTC(a.getFullYear(), a.getMonth(), a.getDate());
  var utc2 = Date.UTC(b.getFullYear(), b.getMonth(), b.getDate());

  return Math.floor((utc2 - utc1) / (1000 * 60 * 60 * 24));
}


function PhaseTimelineController($scope, $rootScope, $element, $attrs, AdminService) {

	var ctrl = this;

	var start_date = new Date();
	var current_date = new Date();
	var end_date = new Date();

	start_date.setDate(start_date.getDate() - 3);
	end_date.setDate(start_date.getDate() + 9);

	ctrl.milestones = {
		start: {
			date: start_date,
			placeholder: 'Start',
			offset: 0
		},
		current: {
			date: current_date,
			placeholder: 'Current',
			offset: 0
		},
		end: {
			date: end_date,
			placeholder: 'End',
			offset: 0
		}
	};

	ctrl.updatePhases = function() {

		AdminService.updatePhases({phases:ctrl.phases}).then(function(response) {

			ctrl.messages = response.errors;
			ctrl.phases = response.data;

			// Update milestone offsets

			ctrl.milestones.start.offset = 0;
			ctrl.milestones.current.offset = (dateDiffInDays(ctrl.milestones.start.date, ctrl.milestones.current.date)) * 60;
			ctrl.milestones.end.offset = (dateDiffInDays(ctrl.milestones.start.date, ctrl.milestones.end.date)) * 60;

    	});

	};

	ctrl.updatePhases();

	$scope.$on('PhaseTimeline::updatePhases', function(event) {

		ctrl.updatePhases();

    });

}
PhaseTimelineController.$inject = ['$scope', '$rootScope', '$element', '$attrs', 'AdminService'];

XMovement.component('phaseTimeline', {
	templateUrl: '/components/phase-timeline',
	controller: PhaseTimelineController
});
