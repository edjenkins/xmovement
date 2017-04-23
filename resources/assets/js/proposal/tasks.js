var selected_tasks = [];

$(document).ready(function() {

	$('.xmovement-propose-tile').click(function() {
		$(this).toggleClass('selected');
		selected_tasks = [];
		$('.xmovement-propose-tile.selected').each(function() {
			selected_tasks.push(JSON.parse($(this).attr('data-design-task')));
		});
		$('#selected_tasks').val(JSON.stringify(selected_tasks));
	});

});
