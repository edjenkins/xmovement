XMovement.controller('ExploreController', function($scope, $http, $rootScope, ExploreService) {

	$scope.ideas = [];

	$scope.getIdeas = function() {

		console.log("Loading ideas");

		ExploreService.getIdeas().then(function(response) {

			console.log(response);

			$scope.ideas = response.data.ideas;

		});
	}

	$scope.getIdeas();

});
