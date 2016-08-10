XMovement.controller('InspirationController', function($scope, $http, $rootScope, $sce, InspirationService) {

	$scope.inspirations = [];
	$scope.selected_inspiration = {};
	$scope.new_inspiration =
	{
		photo: {type:'photo',title:'My Test Photo',description:'If you like tests then you will love this test photograph I never took, it was from the interwebs.',content:''},
		video: {type:'video',title:'My Test Video',description:'If you like tests then you will love this test video I never took, it was from the interwebs.',content:''},
		file: {type:'file',title:'My Test File',description:'If you like tests then you will love this test file I never took, it was from the interwebs.',content:''},
		link: {type:'link',title:'My Test Link',description:'If you like tests then you will love this test link I never took, it was from the interwebs.',content:''}
	};

	$scope.getInspirations = function() {

		console.log("Loading inspirations");

		InspirationService.getInspirations().then(function(response) {

			console.log(response);

			// TODO:
			// $scope.selected_inspiration = $scope.inspirations[0];

			$scope.inspirations = $scope.formatInspirations(response.data.inspirations);

			console.log($scope.inspirations);

			// $('#masonry-grid').masonry();

		});
	}

	$scope.addInspiration = function(type) {

		console.log("Adding inspiration");

		$scope.new_inspiration[type].type = type;

		InspirationService.addInspiration({inspiration: $scope.new_inspiration[type] }).then(function(response) {

			console.log(response);

			if (response.meta.success)
			{
				$scope.inspirations.unshift($scope.formatInspirations([response.data.inspiration])[0]);

				// $('#masonry-grid').imagesLoaded({ background: '.video-tile-image' }).always(function() {
				// 	$('#masonry-grid').masonry('reloadItems');
				// 	$('#masonry-grid').masonry('layout');
				// });

			}

		});
	}

	$scope.formatInspirations = function(inspirations) {

		for (var i = 0; i < inspirations.length; i++)
		{
			if (inspirations[i].type == 'video')
			{
				inspirations[i].content = JSON.parse(inspirations[i].content);
			}
		}

		return inspirations;

	}

	$scope.openInspirationModal = function(inspiration) {

		$scope.selected_inspiration = inspiration;

	}

	$scope.setIframeUrl = function(url) {

		return $sce.trustAsResourceUrl(url);
	}

	$scope.getInspirations();

});
