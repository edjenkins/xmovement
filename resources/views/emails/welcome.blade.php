<body>

	@include('emails/email-header')

	<h3>Welcome to {{ trans('common.brand') }}! We’re so glad you’re here!</h3>

	<p style="font-family: 'Segoe UI Light', 'Segoe UI Web Light', 'Segoe UI Web Regular', 'Segoe UI', 'Segoe UI Symbol', HelveticaNeue-Light, 'Helvetica Neue', Arial, sans-serif; font-size: 1.2em; font-weight: 200; margin: 30px 0; padding: 0;">
		{{ trans('common.brand') }} is a new and exciting way to create and commission training events and courses. Start with an {{ trans_choice('common.idea', 1) }} for an event, involve the community and make it happen! Here’s a super quick tour of what to do next…
	</p>

	<p style="font-family: 'Segoe UI Light', 'Segoe UI Web Light', 'Segoe UI Web Regular', 'Segoe UI', 'Segoe UI Symbol', HelveticaNeue-Light, 'Helvetica Neue', Arial, sans-serif; font-size: 1.2em; font-weight: 200; margin: 30px 0; padding: 0;">
		<a style="color: white; background-color: #6CCCA4; padding: 10px 20px; border-radius: 6px; text-decoration: none; font-weight: normal; font-size: 1.1em;" href="{{ action('IdeaController@index') }}">Browse and Support {{ trans_choice('common.idea', 0) }}</a>
	</p>

	<p style="font-family: 'Segoe UI Light', 'Segoe UI Web Light', 'Segoe UI Web Regular', 'Segoe UI', 'Segoe UI Symbol', HelveticaNeue-Light, 'Helvetica Neue', Arial, sans-serif; font-size: 1.2em; font-weight: 200; margin: 30px 0; padding: 0;">
		Browse other people’s ideas and see something you like? Click support and help develop the {{ trans_choice('common.idea', 1) }} to make it a reality.
	</p>

	<?php // TODO: ADD featured ideas ?>

	<p style="font-family: 'Segoe UI Light', 'Segoe UI Web Light', 'Segoe UI Web Regular', 'Segoe UI', 'Segoe UI Symbol', HelveticaNeue-Light, 'Helvetica Neue', Arial, sans-serif; font-size: 1.2em; font-weight: 200; margin: 30px 0; padding: 0;">
		<a style="color: white; background-color: #6CCCA4; padding: 10px 20px; border-radius: 6px; text-decoration: none; font-weight: normal; font-size: 1.1em;" href="{{ action('IdeaController@add') }}">Start an {{ trans_choice('common.idea', 1) }}</a>
	</p>

	<p style="font-family: 'Segoe UI Light', 'Segoe UI Web Light', 'Segoe UI Web Regular', 'Segoe UI', 'Segoe UI Symbol', HelveticaNeue-Light, 'Helvetica Neue', Arial, sans-serif; font-size: 1.2em; font-weight: 200; margin: 30px 0; padding: 0;">
		Whether your {{ trans_choice('common.idea', 1) }} is fully formed or just a small spark, with a few simple clicks you can start things moving. Gather supporters and make it happen!
	</p>

	<p style="font-family: 'Segoe UI Light', 'Segoe UI Web Light', 'Segoe UI Web Regular', 'Segoe UI', 'Segoe UI Symbol', HelveticaNeue-Light, 'Helvetica Neue', Arial, sans-serif; font-size: 1.2em; font-weight: 200; margin: 30px 0; padding: 0;">
		<strong>Spread the love</strong>
	</p>

	<p style="font-family: 'Segoe UI Light', 'Segoe UI Web Light', 'Segoe UI Web Regular', 'Segoe UI', 'Segoe UI Symbol', HelveticaNeue-Light, 'Helvetica Neue', Arial, sans-serif; font-size: 1.2em; font-weight: 200; margin: 30px 0; padding: 0;">
		{{ trans('common.brand') }} works best when people come together around {{ trans_choice('common.idea', 0) }} to show support, so why not invite friends to get involved with {{ trans_choice('common.idea', 0) }} you think they’ll like?
	</p>

	<?php // TODO: ADD social media links ?>

	<p style="font-family: 'Segoe UI Light', 'Segoe UI Web Light', 'Segoe UI Web Regular', 'Segoe UI', 'Segoe UI Symbol', HelveticaNeue-Light, 'Helvetica Neue', Arial, sans-serif; font-size: 1.2em; font-weight: 200; margin: 30px 0; padding: 0;">
		- The {{ trans('common.brand') }} team
	</p>

	@include('emails/email-footer')

</body>
