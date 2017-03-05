XMovement.controller('InspirationController', function($scope, $http, $rootScope, $sce, $location, $window, InspirationService, DiscussionService) {

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

	$scope.new_inspiration = {
		photo: { type:'photo', description:'', content:'', category:'' },
		video: { type:'video', description:'', content:'', category:'' },
		file: { type:'file', description:'', content:'', category:'' },
		link: { type:'link', description:'', content:'', category:'' }
	};

	$scope.$on('imagesLoaded:loaded', function(event, element){
		$scope.layoutGrid();
    });

	$scope.layoutGrid = function() {
		$scope.$emit('iso-method', {name:'reloadItems', params:null});
		$scope.$emit('iso-method', {name:'reloadItems'});
		$scope.$emit('iso-method', 'reloadItems');
	}

	$('#inspiration-modal').on('show.bs.modal', function (e) {

		$('#inspiration-modal .discussion-wrapper .comments-container').html('');
	});

	$('#inspiration-modal').on('shown.bs.modal', function (e) {

		$scope.$apply(function() {

			$location.hash($scope.selected_inspiration.id);

			var url = $location.absUrl();
			url = url.replace($location.protocol() + '://', '');

			$('#inspiration-modal .discussion-wrapper').attr('data-url', url);
			$('#inspiration-modal .discussion-wrapper').attr('data-target-id', $scope.selected_inspiration.id);
			$('#inspiration-modal .discussion-wrapper').attr('data-target-type', 'Inspiration');

			fetchComments(url);

			$('textarea').expanding();
        });
	});

	$('#inspiration-modal').on('hidden.bs.modal', function (e) {

		$scope.$apply(function() {

			$scope.selected_inspiration = {};

			$location.hash('');
        });
	});

	$scope.pageLoaded = function() {

		console.log('pageLoaded');

		var inspiration_id = $location.hash();
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

	$scope.addInspiration = function(type, input_id) {

		console.log("Adding inspiration");

		$scope.new_inspiration[type].type = type;

		switch (type) {
			case 'photo':
				$scope.new_inspiration['photo'].dimensions = [$('#dropzone-photo').attr('data-file-height'), $('#dropzone-photo').attr('data-file-width')];
				$scope.new_inspiration['photo'].content = $('#dropzone-photo').val();
				if ($('#dropzone-photo').val() == '')
				{
					alert('Please wait for upload to complete');
					return false;
				}
				break;

			case 'file':
				$scope.new_inspiration['file'].content = $('#dropzone-file').val();
				if ($('#dropzone-file').val() == '')
				{
					alert('Please wait for upload to complete');
					return false;
				}
				break;

			default:
				break;
		}

		InspirationService.addInspiration({inspiration: $scope.new_inspiration[type] }).then(function(response) {

			if (response.meta.success)
			{
				var inspiration = response.data.inspiration;

				$scope.inspirations.splice(0,0, $scope.formatInspiration(response.data.inspiration));

				$scope.layoutGrid();
				$scope.openInspirationModal(inspiration);

				// Reset form
				$scope.new_inspiration = {
					photo: { type:'photo', description:'', content:'', category:'' },
					video: { type:'video', description:'', content:'', category:'' },
					file: { type:'file', description:'', content:'', category:'' },
					link: { type:'link', description:'', content:'', category:'' }
				};

				// Reset dropzones
				$('.dropzone').each(function(index) { Dropzone.forElement('#' + $(this).attr('id')).removeAllFiles(); });

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

		if (!inspiration) { return inspiration; }

		inspiration["prepended"] = (inspiration["prepended"]) ? inspiration["prepended"] : false;

		try {
			switch (inspiration.type) {
				case 'photo':
					inspiration.content = JSON.parse(inspiration.content);
					break;
				case 'video':
					inspiration.content = JSON.parse(inspiration.content);
					break;
				default:
			}

		} catch (e) {

			console.error(e);

		} finally {

			return inspiration;
		}
	}

	$scope.openInspirationModal = function(inspiration) {

		$scope.selected_inspiration = inspiration;

		$('#inspiration-modal').modal('show');
	}

	$scope.setIframeUrl = function(url) {

		return $sce.trustAsResourceUrl(url);
	}

	// $scope.fetchComments = function(url) {
	//
	// 	var discussion_wrapper = $('.discussion-wrapper').filter('[data-url="' + url + '"]');
	// 	var post_comment_container = discussion_wrapper.find('.post-comment-container');
	// 	var comments_container = discussion_wrapper.find('.comments-container');
	//
	// 	comments_container.html('');
	//
	// 	var data = {
	// 		url: url,
	// 		target_id: discussion_wrapper.attr('data-target-id'),
	// 		target_type: discussion_wrapper.attr('data-target-type'),
	// 		idea_id: discussion_wrapper.attr('data-idea-id')
	// 	};
	//
	// 	DiscussionService.fetchComments(data).then(function(response) {
	//
	// 		comments_container.html('');
	//
	// 		$.each(response.data.comments, function(index, comment) {
	//
	// 			comments_container.append(comment.view);
	// 		});
	//
	// 		attachHandlers();
	//
	// 		// Hide comment input if locked
	// 		post_comment_container.toggle(!response.data.comment_target.locked);
	// 	});
	// }

	$scope.loadInspirations('popular');
	$scope.pageLoaded();

});
