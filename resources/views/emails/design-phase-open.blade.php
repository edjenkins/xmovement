<body>

	@include('emails/email-header')

	<p style="font-family: 'Segoe UI Light', 'Segoe UI Web Light', 'Segoe UI Web Regular', 'Segoe UI', 'Segoe UI Symbol', HelveticaNeue-Light, 'Helvetica Neue', Arial, sans-serif; font-size: 1.2em; font-weight: 200; margin: 30px 0; padding: 0;">
		Hey {{ $user['name'] }},
	<br /><br />
		Awesome news! The design phase is now open for business. Join the other {{ $idea->supporterCount() }} supporters in designing '<a href="{{ action('IdeaController@view', $idea) }}">{{ $idea->name }}</a>'.
		The power is now in your hands, you can add design tasks for the community to complete, vote on submissions, contributions and tasks and engage with others.
		The design area can be accessed from the campaign page or by clicking <a href="{{ action('DesignController@dashboard', $idea) }}">here</a>.
	<br /><br />
		Have fun, XMovement team
	</p>

	@include('emails/email-footer')

</body>
