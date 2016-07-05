<body>

	@include('emails/email-header')

	<h3>Well {{ $user->name }}, it's been emotional, but {{ $idea->name }} is now complete.</h3>

	<p style="font-family: 'Segoe UI Light', 'Segoe UI Web Light', 'Segoe UI Web Regular', 'Segoe UI', 'Segoe UI Symbol', HelveticaNeue-Light, 'Helvetica Neue', Arial, sans-serif; font-size: 1.2em; font-weight: 200; margin: 30px 0; padding: 0;">
		There were {{ $idea->supporterCount() }} supporters for the idea.
	</p>

	<p style="font-family: 'Segoe UI Light', 'Segoe UI Web Light', 'Segoe UI Web Regular', 'Segoe UI', 'Segoe UI Symbol', HelveticaNeue-Light, 'Helvetica Neue', Arial, sans-serif; font-size: 1.2em; font-weight: 200; margin: 30px 0; padding: 0;">
		The most popular blueprint was:
	</p>

	@include('emails/proposal-tile', ['proposal' => $proposal])

	<p style="font-family: 'Segoe UI Light', 'Segoe UI Web Light', 'Segoe UI Web Regular', 'Segoe UI', 'Segoe UI Symbol', HelveticaNeue-Light, 'Helvetica Neue', Arial, sans-serif; font-size: 1.2em; font-weight: 200; margin: 30px 0; padding: 0;">
		 <a style="color: white; background-color: #6CCCA4; padding: 10px 20px; border-radius: 6px; text-decoration: none; font-weight: normal; font-size: 1.1em;" href="{{ action('ProposeController@index', $idea) }}">Browse other blueprints</a>
	</p>

	<p style="font-family: 'Segoe UI Light', 'Segoe UI Web Light', 'Segoe UI Web Regular', 'Segoe UI', 'Segoe UI Symbol', HelveticaNeue-Light, 'Helvetica Neue', Arial, sans-serif; font-size: 1.2em; font-weight: 200; margin: 30px 0; padding: 0;">
		<strong>So what next?</strong>
	</p>

	<p style="font-family: 'Segoe UI Light', 'Segoe UI Web Light', 'Segoe UI Web Regular', 'Segoe UI', 'Segoe UI Symbol', HelveticaNeue-Light, 'Helvetica Neue', Arial, sans-serif; font-size: 1.2em; font-weight: 200; margin: 30px 0; padding: 0;">
		The Support, Get Involved and Blueprint phases are all closed, so now it’s time to make the idea into a reality. The <a href="{{ action('IdeaController@view', $idea) }}">discussion</a> is still open, so check it out for more information…
	</p>

	<p style="font-family: 'Segoe UI Light', 'Segoe UI Web Light', 'Segoe UI Web Regular', 'Segoe UI', 'Segoe UI Symbol', HelveticaNeue-Light, 'Helvetica Neue', Arial, sans-serif; font-size: 1.2em; font-weight: 200; margin: 30px 0; padding: 0;">
		- The {{ trans('common.brand') }} team
	</p>

	@include('emails/email-footer')

</body>
