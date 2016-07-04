<body>

	@include('emails/email-header')

	<p style="font-family: 'Segoe UI Light', 'Segoe UI Web Light', 'Segoe UI Web Regular', 'Segoe UI', 'Segoe UI Symbol', HelveticaNeue-Light, 'Helvetica Neue', Arial, sans-serif; font-size: 1.2em; font-weight: 200; margin: 30px 0; padding: 0;">
		Hey {{ $user['name'] }},
	<br /><br />
		The proposal phase is now open for '<a href="{{ action('IdeaController@view', $idea) }}">{{ $idea->name }}</a>', this means you can submit a proposal to the community based on the outcomes of the design phase.
		If you don't fancy submitting a proposal yourself then please check back to see proposals submitted by others and vote for your favourite.
		A great proposal takes the most popular descions from each design task and brings them together as a final solution, whilst covering any potential issues.
		The proposal area can be accessed from the campaign page or by clicking <a href="{{ action('ProposeController@index', $idea) }}">here</a>.
	<br /><br />
		Have fun, XMovement team
	</p>

	@include('emails/email-footer')

</body>
