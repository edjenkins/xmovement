<body>

	@include('emails/email-header')

	<h3>{{ $sender->name }} has sent you a direct message.</h3>

	<p style="font-family: 'Segoe UI Light', 'Segoe UI Web Light', 'Segoe UI Web Regular', 'Segoe UI', 'Segoe UI Symbol', HelveticaNeue-Light, 'Helvetica Neue', Arial, sans-serif; font-size: 1.2em; font-weight: 200; margin: 30px 0; padding: 0;">
		"{{ $direct_message->text }}" - {{ $sender->name }}
	</p>

	@include('emails/email-footer')

</body>
