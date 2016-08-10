var text_index = 1;

function initSortable() {
	$( "#sortable" ).sortable({
		items: ".sortable",
		opacity: 0.8,
		create: function( event, ui ) {
			setOrder();
			attachHandlers();
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
}

function attachHandlers() {

	$('textarea').off('change keyup paste').on('change keyup paste', function() {

		$(this).outerHeight(20).outerHeight(this.scrollHeight);

		setOrder();
	});

	$('.fa-trash-o').off('click').on('click', function() {
		var this_text_index = $(this).attr('data-text-index');
		$('#proposal-text-' + this_text_index).remove();
	})

	$('.fa-pencil').off('click').on('click', function() {
		$(this).parent().find('textarea').show();
	})
}

$(document).ready(function() {

	initSortable();

	$( "#sortable" ).disableSelection();

	$('#add-content').click(function() {
		text_index++;
		$('.proposal-preview').append('<li class="proposal-item proposal-text-container sortable" data-proposal-item-type="text" id="proposal-text-' + text_index + '"><i data-text-index="' + text_index + '" class="fa fa-trash-o"></i><textarea class="expanding" name="name" placeholder="Justify your choices with added text..." rows="8" cols="40"></textarea></li>');
		initSortable();
		attachHandlers();
	});

});

function setOrder()
{
	var orderedIds = $("#sortable").sortable("toArray");

	console.log(orderedIds);

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
				var proposal_item_details = item.find('.proposal-item-details').val();
				proposal.push({type:proposal_item_type, id:design_task_id, xmovement_task_type:design_task_xmovement_task_type, contribution_ids:design_task_contribution_ids, proposal_item_details:proposal_item_details});
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

	console.log($('#proposal-input').val());
}
