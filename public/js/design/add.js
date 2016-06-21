$('.design-module-tile').click(function(e) {

	var form_id = $(this).attr('data-form-id');

	showModule(form_id);

	$('.design-module-tile').not(this).removeClass('active');

	$(this).addClass('active');

	Cookies.set('current_design_module', form_id);

	designModuleTileClicked(this);

});

function showModule(form_id) {

	$('.design-module-form').not(form_id).removeClass('active');

	$(form_id).addClass('active');

	var location_hash = form_id + '-hash';

	if (location_hash != '-hash') {

		if (history.pushState) {
		    history.pushState(null, null, location_hash);
		} else {
		    location.hash = location_hash;
		}
	}

	$('select').easyDropDown({
		wrapperClass: 'flat custom-dropdown',
		onChange: function(selected){
			$(form_id + ' form #contribution-type').val(selected.value);
		}
	});
}

$(document).ready(function() {

	var form_id =  (Cookies.get('current_design_module')) ? Cookies.get('current_design_module') : window.location.hash.slice(0, -5);
	Cookies.set('current_design_module', form_id);
	window.location.hash = Cookies.get('current_design_module');
	showModule(form_id);
	$('.design-module-tile[data-form-id="' + form_id + '"]').addClass('active');

	$('select').easyDropDown({
		wrapperClass: 'flat custom-dropdown',
		onChange: function(selected){
			$(form_id + ' form #contribution-type').val(selected.value);
		}
	});
});
