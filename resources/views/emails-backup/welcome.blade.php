<body>

	@include('emails/email-header')

	<p style="font-family: 'Segoe UI Light', 'Segoe UI Web Light', 'Segoe UI Web Regular', 'Segoe UI', 'Segoe UI Symbol', HelveticaNeue-Light, 'Helvetica Neue', Arial, sans-serif; font-size: 1.2em; font-weight: 200; margin: 30px 0; padding: 0;">
		Hey {{ $user['name'] }},
	<br /><br />
		Welcome to XMovement, you are now ready to start creating your own ideas and helping with the design of other peoples!
		{{ $facebook ? " Thanks for registering with Facebook, we will never post without asking first!" : "" }}
	<br /><br />
		Have fun, XMovement team
	</p>

	@include('emails/email-footer')

</body>