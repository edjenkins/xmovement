<body>

	@include('emails/email-header')

	<h3>Thanks for supporting {{ $idea->name }}, so what’s next?</h3>

	<p style="font-family: 'Segoe UI Light', 'Segoe UI Web Light', 'Segoe UI Web Regular', 'Segoe UI', 'Segoe UI Symbol', HelveticaNeue-Light, 'Helvetica Neue', Arial, sans-serif; font-size: 1.2em; font-weight: 200; margin: 30px 0; padding: 0;">
		Ideas go through different phases, and you should get involved in each step to help the {{ trans_choice('common.idea', 1) }} become a reality. In the Get Involved phase you can create talking points to help develop and shape the {{ trans_choice('common.idea', 1) }}. Afterwards, in the Plan It phase, you can help choose what the final event should look like. Check the {{ trans_choice('common.idea', 1) }} page to see what phase it is in.
	</p>

	<p style="font-family: 'Segoe UI Light', 'Segoe UI Web Light', 'Segoe UI Web Regular', 'Segoe UI', 'Segoe UI Symbol', HelveticaNeue-Light, 'Helvetica Neue', Arial, sans-serif; font-size: 1.2em; font-weight: 200; margin: 30px 0; padding: 0;">
		Find out more about phases and how {{ trans('common.brand') }} works on our <a href="{{ action('PageController@about') }}">About page</a>
	</p>

	<p style="font-family: 'Segoe UI Light', 'Segoe UI Web Light', 'Segoe UI Web Regular', 'Segoe UI', 'Segoe UI Symbol', HelveticaNeue-Light, 'Helvetica Neue', Arial, sans-serif; font-size: 1.2em; font-weight: 200; margin: 30px 0; padding: 0;">
		 <a href="{{ action('IdeaController@view', $idea) }}">{{ $idea->name }}</a> will only get stronger, the more people who support it. So spread the word!
	</p>

	<?php // TODO: ADD social media links ?>

	<?php // TODO: ADD featured ideas ?>

	<p style="font-family: 'Segoe UI Light', 'Segoe UI Web Light', 'Segoe UI Web Regular', 'Segoe UI', 'Segoe UI Symbol', HelveticaNeue-Light, 'Helvetica Neue', Arial, sans-serif; font-size: 1.2em; font-weight: 200; margin: 30px 0; padding: 0;">
		- The {{ trans('common.brand') }} team
	</p>

	@include('emails/email-footer')

</body>
