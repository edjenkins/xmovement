$('.design-module-tile').click(function() {

	var form_id = $(this).attr('data-form-id');
	
	$('.design-module-form').not(form_id).removeClass('active');

	$(form_id).addClass('active');
	
	$('.design-module-tile').not(this).removeClass('active');

	$(this).addClass('active');

});


// <div class="design-module-form" id="contribution-form">

// 	@include('forms/xmovement/contribution', ['editing' => false, 'idea' => $idea])

// </div>

// <div class="design-module-form" id="poll-form">

// 	@include('forms/xmovement/poll', ['editing' => false, 'idea' => $idea])

// </div>

// <div class="design-module-form" id="requirement-form">

// 	@include('forms/xmovement/requirement', ['editing' => false, 'idea' => $idea])

// </div>

// <div class="design-module-form" id="ice-cube-tray-form">

// 	@include('forms/xmovement/ice-cube-tray', ['editing' => false, 'idea' => $idea])

// </div>

// <div class="design-module-form" id="external-resource-form">

// 	@include('forms/xmovement/external-resource', ['editing' => false, 'idea' => $idea])

// </div>

// <div class="design-module-form" id="discussion-form">

// 	@include('forms/xmovement/discussion', ['editing' => false, 'idea' => $idea])

// </div>