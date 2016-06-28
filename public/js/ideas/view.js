$(document).ready(function() {

	// Show support modal if necessary
	showSupportModal();

	// Add the handlers for share buttons
	addShareButtonHandlers();

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

function addShareButtonHandlers()
{
	$('.share-fb').click(function(){
		FB.ui({
		  method: 'share',
		  href: idea_url,
		}, function(response){});
	});

	$('.share-twitter').click(function(){
		var url = 'http://twitter.com/home?status=' + idea_url;
		shareWindow(url);
	});

	$('.share-googleplus').click(function(){
		var url = 'https://plus.google.com/share?url=' + idea_url;
		shareWindow(url);
	});

	$('.share-email').click(function(){
		var url = 'mailto:?Subject=' + idea_name + '&Body=' + idea_url;
		window.location.href = url;
	});
}

function shareWindow(windowUri)
{
	var centerWidth = (window.screen.width - 600) / 2;
    var centerHeight = (window.screen.height - 440) / 2;

    newWindow = window.open(windowUri, 'Share Movement', 'resizable=1,width=' + 600 + ',height=' + 440 + ',left=' + centerWidth + ',top=' + centerHeight);
    newWindow.focus();
    return newWindow.name;
}
