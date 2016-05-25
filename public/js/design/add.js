$('.design-module-tile').click(function() {

	var form_id = $(this).attr('data-form-id');
	
	$('.design-module-form').not(form_id).removeClass('active');

	$(form_id).addClass('active');
	
	$('.design-module-tile').not(this).removeClass('active');

	$(this).addClass('active');

	designModuleTileClicked(this);

});