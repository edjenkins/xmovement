function PhaseTimelineController($scope, $rootScope, $element, $attrs, AdminService) {

	var ctrl = this;

	ctrl.milestones = {};

	ctrl.updatePhases = function() {

		AdminService.updatePhases({phases:ctrl.phases}).then(function(response) {

			console.log(response.data);

			ctrl.messages = response.errors;
			ctrl.phases = response.data.phases;
			ctrl.milestones = response.data.milestones;

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
