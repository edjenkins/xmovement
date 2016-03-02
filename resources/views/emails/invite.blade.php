<body>

	@include('emails/email-header')

	<p style="font-family: 'Segoe UI Light', 'Segoe UI Web Light', 'Segoe UI Web Regular', 'Segoe UI', 'Segoe UI Symbol', HelveticaNeue-Light, 'Helvetica Neue', Arial, sans-serif; font-size: 1.2em; font-weight: 200; margin: 30px 0; padding: 0;">
		Hey {{ $receiver['name'] }},
	<br /><br />
		{{ $sender['name'] }} has invited you to support and help design their idea '<a href="{{ $link = url('idea', $idea) }}">{{ $idea['name'] }}</a>', you can get started by following the link below.
	<br /><br />
		<a href="{{ $link = url('idea', $idea) }}">{{ $idea['name'] }}</a>
	<br /><br />
		Have fun, XMovement team
	</p>

	@include('emails/email-footer')

</body>