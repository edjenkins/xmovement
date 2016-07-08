
@if($user->recent_messages)

	<ul class="message-list">

		@foreach($user->recent_messages as $message)

			<li class="message-wrapper">
				<a href="{{ action('UserController@profile', $message->sender) }}" title="{{ $message->sender->name }}" class="message-user" style="background-image: url('{{ ResourceImage::getProfileImage($message->sender, 'medium') }}')"></a>
				<p class="message-bubble">
					{{ $message->text }}
				</p>
				<a href="{{ action('UserController@profile', $message->sender) }}" title="{{ $message->sender->name }}" class="message-info">
					{{ trans('messages.sent_by_x_x', ['name' => $message->sender->name, 'time' => $message->created_at->diffForHumans() ]) }}
				</p>
			</li>

		@endforeach

	</ul>

@else

	<div class="no-content no-messages">
		<h3>{{ trans('profile.no_messages') }}</h3>
	</div>

@endif
