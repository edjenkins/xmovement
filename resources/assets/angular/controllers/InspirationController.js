XMovement.controller('InspirationController', function($scope, $http, $rootScope, $sce, InspirationService) {

	$scope.inspirations = [];
	$scope.selected_inspiration = {};
	$scope.new_inspiration =
	{
		photo: { type:'photo', description:'', content:'' },
		video: { type:'video', description:'', content:'' },
		file: { type:'file', description:'', content:'' },
		link: { type:'link', description:'', content:'' }
	};

	$scope.getInspirations = function() {

		console.log("Loading inspirations");

		InspirationService.getInspirations().then(function(response) {

			console.log(response);

			$scope.inspirations = $scope.formatInspirations(response.data.inspirations);

		});
	}

	$scope.addInspiration = function(type) {

		console.log("Adding inspiration");

		$scope.new_inspiration[type].type = type;

		switch (type) {
			case 'photo':
				$scope.new_inspiration['photo'].content = $('#dropzone-photo').val();
				break;

			case 'video':

				break;

			case 'file':
				$scope.new_inspiration['file'].content = $('#dropzone-file').val();
				break;

			case 'link':

				break;

			default:
				
				break;
		}

		InspirationService.addInspiration({inspiration: $scope.new_inspiration[type] }).then(function(response) {

			console.log(response);

			if (response.meta.success)
			{
				$scope.inspirations.splice($scope.formatInspirations([response.data.inspiration])[0]);
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
