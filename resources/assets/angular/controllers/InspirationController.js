XMovement.controller('InspirationController', function($scope, $http, $rootScope, $sce, $location, InspirationService) {

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

		$scope.loadInspirations('recent');
	}

	$scope.loadInspirations = function(sort_type) {

		$scope.sort_type = sort_type;

		InspirationService.getInspirations({ sort_type: sort_type }).then(function(response) {

			console.log(response);

			switch (sort_type) {

				case 'popular':
					response.data.inspirations = _.sortBy(response.data.inspirations, function(inspiration){ return inspiration.favourited_count; }).reverse();
					break;

				default:
					response.data.inspirations = response.data.inspirations;
					break;

			}

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

			if (response.meta.success)
			{
				// $scope.inspirations.splice(0, 1, $scope.formatInspiration(response.data.inspiration));
				// inspiration["prepended"] = true;
				// $('#masonry-grid').masonry('reload');
				//  | orderBy:sort_type:true
				var inspiration = response.data.inspiration;

				console.log(inspiration);

				// $scope.inspirations.push($scope.formatInspiration(inspiration));
				$scope.inspirations.splice(0,0, $scope.formatInspiration(response.data.inspiration));
			}
		});
	}

	$scope.favouriteInspiration = function(inspiration) {

		console.log("Favouriting inspiration");

		inspiration.favouriting = true;

		InspirationService.favouriteInspiration({ inspiration_id: inspiration.id }).then(function(response) {

			console.log(response);

			if (response.meta.success)
			{
				// Update count
				inspiration.favourited_count = response.data.inspiration.favourited_count;
				inspiration.has_favourited = response.data.inspiration.has_favourited;
			}
			else
			{
				$.each(response.errors, function(index, error) {
					alert(error);
				});
			}

			inspiration.favouriting = false;
		});
	}

	$scope.reportInspiration = function(inspiration) {

		console.log("Reporting inspiration");

		InspirationService.reportInspiration({ reportable_id: inspiration.id, reportable_type: 'inspiration' }).then(function(response) {

			console.log(response);

			if (response.meta.success)
			{
				$.each(response.data.messages, function(index, message) {
					alert(message);
				});
			}
			else
			{
				$.each(response.errors, function(index, error) {
					alert(error);
				});
			}
		});
	}

	$scope.deleteInspiration = function(inspiration) {

		console.log("Deleting inspiration");

		InspirationService.deleteInspiration({ inspiration_id: inspiration.id }).then(function(response) {

			console.log(response);

			if (response.meta.success)
			{
				$('#inspiration-modal').modal('hide');

				$.each(response.data.messages, function(index, message) {
					alert(message);
				});
			}
			else
			{
				$.each(response.errors, function(index, error) {
					alert(error);
				});
			}
		});
	}

	$scope.formatInspirations = function(inspirations) {

		for (var i = 0; i < inspirations.length; i++) {
			$scope.formatInspiration(inspirations[i]);
		}

		return inspirations;
	}


	$scope.formatInspiration = function(inspiration) {

		inspiration["prepended"] = (inspiration["prepended"]) ? inspiration["prepended"] : false;

		if (inspiration.type == 'video')
		{
			inspiration.content = JSON.parse(inspiration.content);
		}

		return inspiration;
	}

	$scope.openInspirationModal = function(inspiration) {

		$location.hash(inspiration.id);

		var url = $location.absUrl();

		fetchComments(url);

		$scope.selected_inspiration = inspiration;
	}

	$scope.setIframeUrl = function(url) {

		return $sce.trustAsResourceUrl(url);
	}

	$scope.getInspirations();

});
