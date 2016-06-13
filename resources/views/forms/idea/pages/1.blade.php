<div class="form-page visible" id="form-page-1" data-title="{{ trans('idea_form.name_your_idea') }}">

	<div class="form-page-content">

		<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">

			<label>{{ trans('idea_form.name_label') }}</label>

			<input type="text" class="form-control" name="name" value="{{ isset($idea) ? old('name', $idea->name) : old('name') }}" placeholder="{{ trans('idea_form.name_placeholder') }}">

			@if ($errors->has('name'))
				<span class="help-block">
					<strong>{{ $errors->first('name') }}</strong>
				</span>
			@endif

		</div>

		<div class="form-group{{ $errors->has('visibility') ? ' has-error' : '' }}">

			<div class="toggle-switch-wrapper">

				<label>{{ trans('idea_form.visibility_label') }}</label>

				<label class="toggle-switch">

					<input type="hidden" class="form-control" name="visibility" id="visibility-input" value="{{ isset($idea) ? old('visibility', $idea->visibility) : old('visibility', 'public') }}">
					@if (isset($idea))
						<div class="toggle-button{{ (old('visibility', $idea->visibility) == 'public') ? ' checked' : '' }}" id="visibility-toggle-button" onClick="$(this).toggleClass('checked'); $('#visibility-input').attr('value', $(this).hasClass('checked') ? 'public' : 'private');"></div>
					@else
						<div class="toggle-button{{ (old('visibility', 'public') == 'public') ? ' checked' : '' }}" id="visibility-toggle-button" onClick="$(this).toggleClass('checked'); $('#visibility-input').attr('value', $(this).hasClass('checked') ? 'public' : 'private');"></div>
					@endif
				</label>

				<div class="clearfloat"></div>

			</div>

			@if ($errors->has('visibility'))
				<span class="help-block">
					<strong>{{ $errors->first('visibility') }}</strong>
				</span>
			@endif

		</div>

		<div class="form-group">
			<div class="btn btn-primary step-button" onClick="nextStep()">{{ trans('idea_form.next_step') }}</div>
		</div>

	</div>

</div>
