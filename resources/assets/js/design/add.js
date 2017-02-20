$('.design-module-tile').click(function(e) {

	var form_id = $(this).attr('data-form-id');

	showModule(form_id);

	$('.design-module-tile').not(this).removeClass('active');

	$(this).addClass('active');

	Cookies.set('current_design_module', form_id);
});

function showModule(form_id) {

	$('.design-module-form').not(form_id).removeClass('active');

	$(form_id).addClass('active');

	$('select').easyDropDown({
		wrapperClass: 'flat custom-dropdown',
		onChange: function(selected){
			$(form_id + ' form #contribution-type').val(selected.value);
		}
	});
}

$(document).ready(function() {

	var form_id =  (Cookies.get('current_design_module')) ? Cookies.get('current_design_module') : '';
	Cookies.set('current_design_module', form_id);
	showModule(form_id);
	$('.design-module-tile[data-form-id="' + form_id + '"]').addClass('active');
});
