$(document).ready(function() {

	showSupportModal();

 })

function showSupportModal()
{
	if (!show_support) { return; }
	
	if (is_authorized)
	{
		$('#support-modal').removeClass('fade').modal('show');
	}
	else
	{
		if (auth_type == 'login')
		{
			$('#login-tab, #login-panel').addClass('active');
			$('#register-tab, #register-panel').removeClass('active');
		}
		else if (auth_type == 'register')
		{
			$('#login-tab, #login-panel').removeClass('active');
			$('#register-tab, #register-panel').addClass('active');
		}

		$('#auth-modal').removeClass('fade').modal('show');
	}
}