$('.design-module-tile').click(function(e) {

	var form_id = $(this).attr('data-form-id');

	showModule(form_id);

	$('.design-module-tile').not(this).removeClass('active');

	$(this).addClass('active');

	designModuleTileClicked(this);

});

function showModule(form_id) {

	$('.design-module-form').not(form_id).removeClass('active');

	$(form_id).addClass('active');

	var location_hash = form_id + '-hash';

	if (history.pushState) {
	    history.pushState(null, null, location_hash);
	} else {
	    location.hash = location_hash;
	}
}

$(document).ready(function() {

	var form_id = window.location.hash.slice(0, -5);
	showModule(form_id);
	$('.design-module-tile[data-form-id="' + form_id + '"]').addClass('active');

});
