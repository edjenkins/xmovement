XMovement.controller('TenderController', function($scope, $http, $rootScope, $location, TenderService, TeamService, UpdateService, DiscussionService) {

	$scope.tender = tender;
	$scope.user_search_results = [];
	$scope.no_search_results = false;
	$scope.selected_tender_question = {};

	$scope.$watch('user_search_term', function() {

		$scope.searchUsers();

	}, true);

	$scope.getTender = function(tender_id) {

		TenderService.getTender({tender_id:tender_id}).then(function(response) {

			$scope.tender = response.data.tender;
		})
	}

	$('#tender-question-modal').on('show.bs.modal', function (e) {

		$('#tender-question-modal .discussion-wrapper .comments-container').html('');
	});

	$('#tender-question-modal').on('shown.bs.modal', function (e) {

		$scope.$apply(function() {

			$location.hash($scope.selected_tender_question.id);

			$('#tender-question-modal .discussion-wrapper').attr('data-url', $location.absUrl());

			$scope.fetchComments($location.absUrl());
        });
	});

	$('#tender-question-modal').on('hidden.bs.modal', function (e) {

		$scope.$apply(function() {

			$scope.selected_tender_question = {};

			$location.hash('');
        });
	});

	$scope.openQuestionModal = function(answer) {

		$scope.selected_tender_question = answer;

		$('#tender-question-modal').modal('show');
	}

	$scope.fetchComments = function(url) {

		var discussion_wrapper = $('.discussion-wrapper[data-url="' + url + '"]');
		var post_comment_container = discussion_wrapper.find('.post-comment-container');
		var comments_container = discussion_wrapper.find('.comments-container');

		comments_container.html('');

		var data = {
			url: url,
			target_id: discussion_wrapper.attr('data-target-id'),
			target_type: discussion_wrapper.attr('data-target-type'),
			idea_id: discussion_wrapper.attr('data-idea-id')
		};

		DiscussionService.fetchComments(data).then(function(response) {

			comments_container.html('');

			$.each(response.data.comments, function(index, comment) {

				comments_container.append(comment.view);
			});

			attachHandlers();

			// Hide comment input if locked
			post_comment_container.toggle(!response.data.comment_target.locked);
		});
	}

	$scope.postUpdate = function() {

		// button.addClass('posting');

		UpdateService.postUpdate({updateable_type: 'tender', updateable_id: $scope.tender.id, text: $scope.update}).then(function(response) {

			console.log(response);

			if (response.meta.success)
			{
				$scope.update = '';

				$scope.tender.updates.push(response.data.update);
			}

			// button.removeClass('posting');

		});

		//
		// function destroyUpdate(delete_button)
		// {
		// 	var result = confirm(delete_button.attr('data-delete-confirmation'));
		//
		// 	if (!result)
		// 	    return;
		//
		// 	var update_id = delete_button.attr('data-update-id');
		//
		// 	$.ajaxSetup({
		//         headers: {
		//         	'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
		//         	'Content-type': 'application/json'
		//         }
		// 	});
		//
		//     $.ajax({
		//         type:"DELETE",
		//         url: "/api/update/destroy",
		//         dataType: "json",
		//         data:  JSON.stringify({update_id: update_id}),
		//         processData: false,
		//         success: function(response) {
		//
		//         	if (response.meta.success)
		//         	{
		// 				// Remove element from DOM
		// 				$('#update-' + update_id).remove();
		// 			}
		//         	else
		//         	{
		//         		// Output errors
		//         		$.each(response.errors, function(index, value) {
		//         			alert(value);
		//         		})
		//         	}
		//         },
		//         error: function(response) {
		// 			console.log(response);
		//         	alert('Something went wrong!');
		//         }
		//     });
		// }
		//
		// function addDestroyUpdateHandlers()
		// {
		// 	$('.destroy-update-button').off('click').on('click', function() {
		//
		// 		destroyUpdate($(this));
		//
		// 	});
		// }




	}

	$scope.searchUsers = function() {

		console.log("Loading users");

		$scope.user_search_results = [];

		$scope.searching_users = true;

		if ($scope.user_search_term.length > 1)
		{
			TeamService.searchUsers({name:$scope.user_search_term, team_id:$scope.tender.team.id}).then(function(response) {

				$scope.user_search_results = response.data.users;

				if (response.data.users.length == 0)
				{
					$scope.no_search_results = true;
				}

				$scope.searching_users = false;

			});
		}
		else
		{
			$scope.searching_users = false;
			$scope.no_search_results = false;
		}
	}

    $scope.getProfileImage = function(user, size) {

		if (user.avatar == 'avatar')
		{
			return '/dynamic/avatar/' + size + '?name=' + encodeURIComponent(user.name);
		}
		else
		{
			return 'https://s3.amazonaws.com/xmovement/uploads/images/' + size + '/' + user.avatar;
		}
    }

	$scope.addUserToTeam = function(user) {

		$scope.user_search_term = '';
		$scope.searching_users = false;
		$scope.user_search_results = [];

		TeamService.addUser({team_id:$scope.tender.team.id, user_id:user.id}).then(function(response) {

			if (response.meta.success)
			{
				$scope.getTender($scope.tender.id);
			}

		});
	}

	$scope.removeUserFromTeam = function(user) {

		TeamService.removeUser({team_id:$scope.tender.team.id, user_id:user.id}).then(function(response) {

			if (response.meta.success)
			{
				$scope.getTender($scope.tender.id);
			}

		});
	}

	$scope.getTender($scope.tender.id);
});
