@can('postUpdate', $idea)

	<div class="post-update-container">

		<div class="creator-avatar" style="background-image:url('{{ ResourceImage::getProfileImage($idea->user, 'medium') }}')"></div>

		<div class="update-composer-wrapper">

			<textarea class="expanding" rows="1" id="update-text-input" name="text" placeholder="{{ trans('idea.update_text_placeholder') }}"></textarea>

			<button type="button" class="post-update-button" id="post-update-button" data-action-type="update" data-idea-id="{{ $idea->id }}" data-user-id="{{ Auth::user()->id }}">
				<span class="idle-state">
					{{ trans('idea.update_button_idle') }}
				</span>
				<span class="posting-state">
					{{ trans('idea.update_button_posting') }}
				</span>
			</button>

			<ul class="error-list" id="update-errors"></ul>

		</div>

	</div>

@endcan


<ul class="updates-list">

	@foreach ($updates as $update)

		@include('ideas.update')

	@endforeach

</ul>
