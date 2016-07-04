<body>

	@include('emails/email-header')

	<p style="font-family: 'Segoe UI Light', 'Segoe UI Web Light', 'Segoe UI Web Regular', 'Segoe UI', 'Segoe UI Symbol', HelveticaNeue-Light, 'Helvetica Neue', Arial, sans-serif; font-size: 1.2em; font-weight: 200; margin: 30px 0; padding: 0;">
		Hey {{ $receiver['name'] }},
	<br /><br />
		You've been invited by <a href="{{ action('UserController@profile', $sender) }}">{{ $sender['name'] }}</a> to support their {{ trans_choice('common.idea', 1) }} '<a href="{{ action('IdeaController@view', $idea) }}">{{ $idea->name }}</a>' on {{ trans('common.brand') }}.
	<br /><br />
		{{ trans('common.brand') }} is a new and exciting way to create and commission training events and courses.
	</p>

	<p style="font-family: 'Segoe UI Light', 'Segoe UI Web Light', 'Segoe UI Web Regular', 'Segoe UI', 'Segoe UI Symbol', HelveticaNeue-Light, 'Helvetica Neue', Arial, sans-serif; font-size: 1.2em; font-weight: 200; margin: 30px 0; padding: 0;">
		View and support their {{ trans_choice('common.idea', 1) }} <a href="{{ action('IdeaController@view', $idea) }}">here</a> and help it develop!
	</p>

	<p style="font-family: 'Segoe UI Light', 'Segoe UI Web Light', 'Segoe UI Web Regular', 'Segoe UI', 'Segoe UI Symbol', HelveticaNeue-Light, 'Helvetica Neue', Arial, sans-serif; font-size: 1.2em; font-weight: 200; margin: 30px 0; padding: 0;">
		- The {{ trans('common.brand') }} team
	</p>

	@include('emails/email-footer')

</body>
