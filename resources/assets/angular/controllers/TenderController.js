XMovement.controller('TenderController', function($scope, $http, $rootScope, TenderService, TeamService, UpdateService) {

	$scope.tender = tender;
	$scope.user_search_results = [];
	$scope.no_search_results = false;
	$scope.selected_question = {};

	$scope.pageLoaded = function() {
		var tender_id = $location.search().id;
		if (tender_id) {
			$scope.getTender(tender_id);
		}
	}

	$scope.$watch('user_search_term', function() {

		$scope.searchUsers();

	}, true);

	$('#tender-question-modal').on('hide.bs.modal', function (e) {
		$scope.selected_question = {};
		$location.search('id', null);
	});

	$scope.getTender = function(tender_id) {

		TenderService.getTender({tender_id:tender_id}).then(function(response) {

			$scope.tender = response.data.tender;

		})
	}

	$scope.openQuestionModal = function(answer) {

		$location.search('id', answer.id);

		var url = $location.absUrl();

		$scope.fetchComments(url);

		$scope.selected_answer = answer;

		$('#tender-question-modal').modal('show');
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

	$scope.getTender($scope.tender.id);
	// $scope.pageLoaded();
});
