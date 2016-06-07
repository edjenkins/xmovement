$(document).ready(function() {

	$( "#sortable" ).sortable({
		items: ".sortable",
		opacity: 0.8,
		create: function( event, ui ) {
			setOrder();
		},
		start: function( event, ui ) {
			$(this).addClass('sorting');
		},
		stop: function( event, ui ) {
			$(this).removeClass('sorting');
		},
		update: function( event, ui ) {
			setOrder();
		},
	});

	$( "#sortable" ).disableSelection();

	$('textarea').on('change keyup paste', function() {
	    setOrder();
	});

});

function setOrder()
{
	var orderedIds = $("#sortable").sortable("toArray");

	// Loop through order and build proposal
	var proposal = [];

	$.each(orderedIds, function( index, item_id ) {
		var item = $('#' + item_id);
		var proposal_item_type = item.attr('data-proposal-item-type');

		switch (proposal_item_type) {
			case 'task':
				var design_task_id = item.attr('data-design-task-id');
				var design_task_xmovement_task_type = item.attr('data-design-task-xmovement-task-type');
				var design_task_contribution_ids = item.attr('data-design-task-contribution-ids');
				proposal.push({type:proposal_item_type, id:design_task_id, xmovement_task_type:design_task_xmovement_task_type, contribution_ids:design_task_contribution_ids});
				break;
			case 'text':
				var design_task_id = item.attr('data-design-task-id');
				var design_task_xmovement_task_type = item.attr('data-design-task-xmovement-task-type');
				proposal.push({type:proposal_item_type, text:item.children('textarea').val()});
				break;
			default:

		}
	});

	$('#proposal-input').val(JSON.stringify(proposal));
}
