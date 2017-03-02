XMovement.controller('ExploreController', function($scope, $http, $rootScope, ExploreService, CategoryService) {

	$scope.loading_ideas = true;
	$scope.loading_categories = true;

	$scope.selected_primary_category = undefined;
	$scope.selected_secondary_category = undefined;

	$scope.primary_categories = [];
	$scope.secondary_categories = [];

	$scope.ideas = [];

	$scope.$watch('sort_type', function() {

		$scope.getIdeas($scope.sort_type);

	}, true);

	$scope.setSortType = function(sort_type) {

		if ($scope.sort_type != sort_type)
		{
			$scope.ideas = [];
			$scope.sort_type = sort_type;
		}

		$scope.getIdeas($scope.sort_type);
	}

	$scope.filterIdeas = function(category_id) {

		$scope.category_filter = category_id;
	}

	$scope.getIdeas = function(sort_type) {

		console.log("Loading ideas");

		$scope.loading_ideas = true;

		switch (sort_type)
		{
			case 'shortlist':
				$scope.sort_order = 'supporters';
				break;
			case 'recent':
				$scope.sort_order = 'created_at';
				break;
			case 'popular':
				$scope.sort_order = 'supporters';
				break;
			default:
				$scope.sort_order = 'supporters';
		}

		ExploreService.getIdeas({'sort_type': sort_type}).then(function(response) {

			$scope.ideas = response.data.ideas;

			$scope.loading_ideas = false;

		});
	}

	$scope.getCategories = function() {

		console.log("Loading categories");

		$scope.loading_categories = true;

		CategoryService.getIdeaCategories().then(function(response) {

			console.log(response);

			$scope.primary_categories = response.data.primary_categories;
			$scope.secondary_categories = response.data.secondary_categories;

			$scope.loading_categories = false;

		});
	}

	$scope.setPrimaryCategory = function(category) {
		$scope.selected_primary_category = category;
	}

	$scope.setSecondaryCategory = function(category) {
		$scope.selected_secondary_category = category;
	}

	// Init
	$scope.getCategories();
});
