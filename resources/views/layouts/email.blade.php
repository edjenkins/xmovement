<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Email</title>
	</head>

	<body style="background-color: #f2f2f2; padding: 20px">

		@include('emails/email-header')

		<div style="background-color: white; border-radius: 6px; margin: 0px auto; max-width: 540px">

			@section('content')
			@show

		</div>

		@include('emails/email-footer')

	</body>

</html>
