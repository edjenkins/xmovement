XMovement.controller('AddTenderController', function($scope, $http, $rootScope, $location, TenderService, TeamService) {

	$scope.adding_team = false;
	$scope.selected_team = null;
	$scope.teams = [];

	$scope.getTeams = function() {

		TeamService.getTeams().then(function(response) {

			if (response.meta.success)
			{
				$scope.teams = response.data.teams;
			}

		})
	}

	$scope.selectTeam = function(team) {

		if (team == null)
		{
			$scope.selected_team = null;
			$scope.adding_team = ($scope.adding_team) ? false : true;
		}
		else if (team == $scope.selected_team)
		{
			$scope.adding_team = false;
			$scope.selected_team = null;
		}
		else
		{
			$scope.adding_team = false;
			$scope.selected_team = team;
		}

		setTimeout(function() {

			$('textarea').expanding();

		}, 500);
	}

	$scope.getTeams();

});
