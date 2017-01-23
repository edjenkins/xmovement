XMovement.directive('xmPhaseTimelineItem', ['$document', '$rootScope', '$filter', '$timeout', 'AdminService', function($document, $rootScope, $filter, $timeout, AdminService) {
	return {
		restrict: 'AE',
		templateUrl: '/directives/phase',
		scope: {
			phase: '=xmPhaseTimelineItem',
			phaseTimelineCtrl: '=xmPhaseTimelineCtrl'
		},
		controllerAs: 'configController',
		controller: ['$rootScope', '$scope', function($rootScope, $scope) {

			var ConfigController = this;

			this.performAction = function(element, update) {

				var original_phase = $scope.phase;

				$scope.$apply(function() {
					$scope.phase.start = Math.round(element.children('.tab').attr('data-start'));
					$scope.phase.duration = Math.round(element.children('.tab').attr('data-duration'));
					$scope.phase.end = $scope.phase.start + $scope.phase.duration;
				});

				if (update)
				{
					$scope.phaseTimelineCtrl.updatePhases();
				}

			}
		}],
		link: function($scope, element, attrs, ctrl) {

			var handle_grabbed = null;
			var timeline_tab;
			var pixel_width = 60;
			var pixel_shift = 0;
			var pointer_offset = 0;

			$scope.handleGrabbed = function(event, element, position)
			{
				handle_grabbed = position;
				timeline_tab = element;
			}

			$('.left-grab-handle').on('mousedown', function(event) {

				$scope.handleGrabbed(event, $(this), 'left');
			});

			$('.right-grab-handle').on('mousedown', function(event) {

				$scope.handleGrabbed(event, $(this), 'right');
			});

			element.children('.tab').children('.inner-tab').on('mousedown', function(event) {

				$(this).removeClass('animated');

				if (handle_grabbed) { return; }

				if ($(this).hasClass('left-grab-handle'))
				{
					handle_grabbed = 'left';
				}
				else if ($(this).hasClass('right-grab-handle'))
				{
					handle_grabbed = 'right';
				}
				else
				{
					handle_grabbed = 'center';
				}

				$scope.handleGrabbed(event, $(this), handle_grabbed);

			});

			// $('body').on('mouseup', function(event) {
			element.children('.tab').on('mouseup', function(event) {

				var current_handle_grabbed = handle_grabbed;

				handle_grabbed = null;

				element.children('.tab').children('.inner-tab').addClass('animated');

				switch (current_handle_grabbed) {

					case 'center':

						var shift = ((event.pageX + pointer_offset) - timeline_tab.parent().offset().left) - timeline_tab.offset().left;

						shift = timeline_tab.offset().left + shift - (timeline_tab.outerWidth() / 2);

						pixel_shift = Math.round(shift / pixel_width) * pixel_width;

						if (pixel_shift >= 0)
						{
							timeline_tab.css({'left':pixel_shift});
						}

						timeline_tab.parent().attr('data-start', Math.round(shift / pixel_width));

						break;

					case 'left':

						var shift = ((event.pageX + pointer_offset) - timeline_tab.parent().parent().offset().left) - timeline_tab.offset().left;

						shift = timeline_tab.offset().left + shift - (timeline_tab.parent().find('.grab-handle').outerWidth() / 2);

						pixel_shift = Math.round(shift / pixel_width) * pixel_width;

						if (pixel_shift >= 0)
						{
							var old_left = timeline_tab.parent().position().left;
							var element_width = timeline_tab.parent().outerWidth();

							var width = (element_width - ((shift - $('.process-timeline').scrollLeft()) - old_left));

							var calc_width = Math.round(width / pixel_width) * pixel_width;

							timeline_tab.parent().css({'left':pixel_shift});
							timeline_tab.parent().css({'width':calc_width});

							timeline_tab.parent().parent().attr('data-duration', Math.round(width / pixel_width));
							timeline_tab.parent().parent().attr('data-start', Math.round(pixel_shift / pixel_width));
						}

						break;

					case 'right':

						var old_right = timeline_tab.parent().position().left + timeline_tab.parent().outerWidth();
						var element_width = timeline_tab.parent().outerWidth();

						var width = (element_width + (((event.pageX + pointer_offset) - timeline_tab.parent().parent().offset().left) - old_right)) + (timeline_tab.parent().find('.grab-handle').outerWidth() / 2);

						var new_width = Math.round(width / pixel_width) * pixel_width;

						new_width -= $('.process-timeline').scrollLeft();

						timeline_tab.parent().css({'width':new_width});

						timeline_tab.parent().parent().attr('data-duration', Math.round(new_width / pixel_width));

						break;

					default:

				}

				// Update values
				ctrl.performAction(element, true);

				pointer_offset = 0;

			});

			$('body').on('mousemove', function(event) {
			// element.children('.tab').on('mousemove', function(event) {

				switch (handle_grabbed) {

					case 'center':

						if (pointer_offset == 0)
						{
							var shift = (event.pageX - timeline_tab.parent().offset().left) - timeline_tab.offset().left;

							shift = timeline_tab.offset().left + shift - (timeline_tab.outerWidth() / 2);

							pointer_offset = $('.process-timeline').scrollLeft() + timeline_tab.position().left - shift;
						}

						var shift = ((event.pageX + pointer_offset) - timeline_tab.parent().offset().left) - timeline_tab.offset().left;

						shift = timeline_tab.offset().left + shift - (timeline_tab.outerWidth() / 2);

						if (shift >= 0)
						{
							timeline_tab.css({'left':shift});
						}

						break;

					case 'left':

						var shift = (event.pageX - timeline_tab.parent().parent().offset().left) - timeline_tab.offset().left;

						shift = timeline_tab.offset().left + shift - (timeline_tab.parent().find('.grab-handle').outerWidth() / 2);

						if (shift >= 0)
						{
							var old_left = timeline_tab.parent().position().left;
							var element_width = timeline_tab.parent().outerWidth();
							var width = (element_width - ((shift - $('.process-timeline').scrollLeft()) - old_left));

							timeline_tab.parent().css({'width':width});
							timeline_tab.parent().css({'left':shift});
						}

						break;

					case 'right':

						var old_right = timeline_tab.parent().position().left + timeline_tab.parent().outerWidth();
						var element_width = timeline_tab.parent().outerWidth();

						var width = (element_width + ((event.pageX - timeline_tab.parent().parent().offset().left) - old_right)) + (timeline_tab.parent().find('.grab-handle').outerWidth() / 2);

						width -= $('.process-timeline').scrollLeft();

						timeline_tab.parent().css({'width':width});

						timeline_tab.parent().parent().attr('data-duration', Math.round(width / pixel_width) );

						break;

					default:

				}

				// Update values
				ctrl.performAction(element, false);

			});
		}
	};
}]);
