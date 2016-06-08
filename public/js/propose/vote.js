$(document).ready(function() {

	addHandlers();

});

function addHandlers()
{
	$('.vote-container.proposal-vote-container .vote-button').off("click").click(function() {

		var vote_button = $(this);
		var vote_container = $(this).parents('.vote-controls').parents('.vote-container');

		var vote_direction = $(this).attr('data-vote-direction');
		var votable_id = $(this).attr('data-votable-id');
		var votable_type = $(this).attr('data-votable-type');

		addVote(vote_button, vote_container, vote_direction, votable_id, votable_type);

	});
}
