//app.js

$(document).ready(function() {

    $(window).scroll(function() {

		if ($(window).scrollTop() > 50) {
			$('body').removeClass('fade-nav');
		} else {
			$('body').addClass('fade-nav');
		}

	});

    // Hide flash messages
    setTimeout(function() { $('.flash').fadeOut(300, function() { $('.flash').remove(); }); }, 2000);

});

function getURLParam(param)
{
    var pageURL = window.location.search.substring(1);
    var URLVariables = pageURL.split('&');
    for (var i = 0; i < URLVariables.length; i++)
    {
        var parameterName = URLVariables[i].split('=');
        if (parameterName[0] == param)
        {
            return parameterName[1];
        }
    }
}

function showJSflash(message, type)
{
    var flash_message = '<div class="flash ' + type + '">' + message + '</div>';

    $('body').append(flash_message);
    
    setTimeout(function() { $('.flash').fadeOut(300, function() { $('.flash').remove(); }); }, 2000);
}