XMovement.controller('InspirationController', function($scope, $http, $rootScope, $sce, $location, $window, InspirationService) {

	var w = angular.element($window);

	var ticker = setInterval(function() {
		$scope.layoutGrid();
	}, 2000);

	w.bind('resize', function () {
		console.log('resize');
		$scope.layoutGrid();
	});

	$scope.loading_inspirations = true;
	$scope.inspirations = [];
	$scope.selected_inspiration = {};
	$scope.inspiration_form_data =
	{
		photo: { type:'photo', description:'', content:'', category:'' },
		video: { type:'video', description:'', content:'', category:'' },
		file: { type:'file', description:'', content:'', category:'' },
		link: { type:'link', description:'', content:'', category:'' }
	};

	$scope.new_inspiration = $scope.inspiration_form_data;

	$scope.$on('imagesLoaded:loaded', function(event, element){
		// setTimeout(function() { $scope.layoutGrid(); }, 200);
		$scope.layoutGrid();
    });

	$scope.layoutGrid = function() {
		$scope.$emit('iso-method', {name:'reloadItems', params:null});
		$scope.$emit('iso-method', {name:'reloadItems'});
		$scope.$emit('iso-method', 'reloadItems');
	}

	$('#inspiration-modal').on('hide.bs.modal', function (e) {
		$scope.selected_inspiration = {};

		if (history.pushState) {
		    var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname;
		    window.history.pushState({path:newurl},'',newurl);

			$scope.fetchComments(newurl);
		}
	});

	$scope.pageLoaded = function() {

		var inspiration_id = $location.search().inspiration_id;
		if (inspiration_id) {
			$scope.loadInspiration(inspiration_id);
		}
	}

	$scope.loadInspirations = function(sort_type) {

		$scope.loading_inspirations = true;

		$scope.sort_type = sort_type;

		$scope.inspirations = [];

		InspirationService.getInspirations({ sort_type: sort_type }).then(function(response) {

			switch (sort_type) {

				case 'popular':
					response.data.inspirations = _.sortBy(response.data.inspirations, function(inspiration){ return inspiration.favourited_count; }).reverse();
					break;

				default:
					response.data.inspirations = response.data.inspirations;
					break;

			}

			$scope.inspirations = $scope.formatInspirations(response.data.inspirations);

			$scope.layoutGrid();

			$scope.loading_inspirations = false;
		});
	}

	$scope.loadInspiration = function(inspiration_id) {

		InspirationService.getInspiration({ inspiration_id: inspiration_id }).then(function(response) {

			if (response.meta.success)
			{
				$scope.openInspirationModal(response.data.inspiration);
			}
			else
			{
				console.log('Request failed');
			}

		});
	}

	$scope.addInspiration = function(type) {

		console.log("Adding inspiration");

		$scope.new_inspiration[type].type = type;

		switch (type) {
			case 'photo':
				$scope.new_inspiration['photo'].content = $('#dropzone-photo').val();
				break;

			case 'file':
				$scope.new_inspiration['file'].content = $('#dropzone-file').val();
				break;

			default:
				break;
		}

		InspirationService.addInspiration({inspiration: $scope.new_inspiration[type] }).then(function(response) {

			if (response.meta.success)
			{
				var inspiration = response.data.inspiration;

				// $scope.inspirations.push($scope.formatInspiration(inspiration));
				$scope.inspirations.splice(0,0, $scope.formatInspiration(response.data.inspiration));

				setTimeout(function() {
					$scope.layoutGrid();
					$scope.openInspirationModal(inspiration);
				}, 2000);

				// Reset form
				$scope.new_inspiration = $scope.inspiration_form_data;
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

				$scope.loadInspirations($scope.sort_type);

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

		if (inspirations)
		{
			for (var i = 0; i < inspirations.length; i++) {
				$scope.formatInspiration(inspirations[i]);
			}
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

		if (history.pushState) {
		    var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + '?inspiration_id=' + inspiration.id;
		    window.history.pushState({path: newurl}, '', newurl);

			$('#inspiration-modal #comments-container').attr('data-url', newurl);

			$scope.fetchComments(newurl);
		}

		$scope.selected_inspiration = inspiration;

		$('#inspiration-modal').modal('show')
	}

	$scope.setIframeUrl = function(url) {

		return $sce.trustAsResourceUrl(url);
	}
	$scope.fetchComments = function(url) {

		$('#comments-container').html('');

		$.getJSON("/api/comment/view", {url: url} , function(response) {

			if (response) {

				$('#comments-container').html('');

				$.each(response.data.comments, function(index, comment) {

					$('#comments-container').append(comment.view);

				})

				attachHandlers();

				// startListening();
			}
		});

	}

	$scope.loadInspirations('popular');
	$scope.pageLoaded();

});
