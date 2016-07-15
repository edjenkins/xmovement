<body>

	@include('../../../emails/email-header')

	<p style="font-family: 'Segoe UI Light', 'Segoe UI Web Light', 'Segoe UI Web Regular', 'Segoe UI', 'Segoe UI Symbol', HelveticaNeue-Light, 'Helvetica Neue', Arial, sans-serif; font-size: 1.2em; font-weight: 200; margin: 30px 0; padding: 0;">
		Hey {{ $name }},
	<br /><br />
		You have been nominated by {{ $user['name'] }} to fill the following requirement - <a href="{{ $link }}">{{ $link }}</a>
	<br /><br />
		{{ $user['name'] }} added the following message:
	<br /><br />
		"{{ $personal_message }}"
	</p>

	@include('../../../emails/email-footer')

</body>
