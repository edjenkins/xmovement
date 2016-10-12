XMovement.controller('AnalyticsController', function($scope, $http, $rootScope, $localStorage, $sessionStorage, AnalyticsService) {

	$scope.$storage = $localStorage.$default({
		analytics_type: 'overview'
	});

	$scope.overview = [];
	$scope.users = [];
	$scope.ideas = [];

	$scope.headers = {
		users: [
			{name: 'Name', type: 'name'},
			{name: 'Email', type: 'email'},
			{name: 'Created', type: 'created_at'},
			{name: 'Ideas', type: 'ideas'},
			{name: 'Tasks', type: 'design_tasks'},
			{name: 'Votes', type: 'design_task_votes'},
			{name: 'Proposals', type: 'proposals'},
			{name: 'Comments', type: 'comments'},
		],
		ideas: [
			{name: 'Name', type: 'name'},
			{name: 'Creator', type: 'creator'},
			{name: 'Supporters', type: 'supporters'},
			{name: 'Proposals', type: 'proposals'},
			{name: 'Comments', type: 'comments'},
			{name: 'Duration', type: 'duration'},
			{name: 'Tasks', type: 'design_tasks'},
			{name: 'Progress', type: 'progress'},
			{name: 'Share Button Clicks', type: 'share_button_clicks'},
			{name: 'Created', type: 'created'},
		]
	};

	$scope.getOverviewAnalytics = function() {

		AnalyticsService.getOverviewAnalytics().then(function(response) {

			$scope.overview = response.data.overview;

		});

	}

	$scope.getUserAnalytics = function() {

		AnalyticsService.getUserAnalytics().then(function(response) {

			$scope.users = response.data.users;

		});
	}

	$scope.getIdeaAnalytics = function() {

		AnalyticsService.getIdeaAnalytics().then(function(response) {

			$scope.ideas = response.data.ideas;

			console.log(response.data.ideas[0]);

		});
	}

	$scope.toggleDetailRow = function(user, column) {

		user.visible_detail_row = (column == user.visible_detail_row) ? '' : column;

	}

	$scope.setAnalyticsType = function(analytics_type) {

		$scope.$storage['analytics_type'] = analytics_type;

		switch ($scope.$storage['analytics_type']) {
			case 'overview':
				$scope.getOverviewAnalytics();
				break;
			case 'users':
				$scope.getUserAnalytics();
				break;
			case 'ideas':
				$scope.getIdeaAnalytics();
				break;
			default:
				$scope.getOverviewAnalytics();
				break;
		}
	}

	$scope.setAnalyticsType($scope.$storage['analytics_type']);

});
