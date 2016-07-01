<body>

	@include('emails/email-header')

	<p style="font-family: 'Segoe UI Light', 'Segoe UI Web Light', 'Segoe UI Web Regular', 'Segoe UI', 'Segoe UI Symbol', HelveticaNeue-Light, 'Helvetica Neue', Arial, sans-serif; font-size: 1.2em; font-weight: 200; margin: 30px 0; padding: 0;">
		Hey {{ $user['name'] }},
	<br /><br />
		The proposal phase is now complete for '<a href="{{ action('IdeaController@view', $idea) }}">{{ $idea->name }}</a>', the winning proposal phase can be seen on the campaign page or in the proposals view <a href="{{ action('ProposeController@index', $idea) }}">here</a>.
	<br /><br />
		Have fun, XMovement team
	</p>

	@include('emails/email-footer')

</body>
