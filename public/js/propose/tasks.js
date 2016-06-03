var selected_tasks = [];

$(document).ready(function() {

	$('.xmovement-propose-tile').click(function() {
		$(this).toggleClass('selected');
		selected_tasks = [];
		$('.xmovement-propose-tile.selected').each(function() {
			var xmovement_task_id = $(this).attr('data-id');
			selected_tasks.push(xmovement_task_id);
		});
		$('#selected_tasks').val(JSON.stringify(selected_tasks));
		console.log(JSON.stringify(selected_tasks));
	});

});
