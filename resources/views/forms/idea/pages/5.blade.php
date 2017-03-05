<div class="form-page animated <?php if (!$errors->isEmpty()) { echo 'visible'; } ?>" id="form-page-5" data-title="{{ trans('idea_form.settings') }}">

	<div class="form-page-content">

		<!-- Check if user can set duration of idea -->
		<!-- DynamicConfig::fetchConfig('FIXED_IDEA_DURATION', 0) == 0 -->
		@if (false)

			<div class="form-group{{ $errors->has('duration') ? ' has-error' : '' }}" id="duration-slider-wrapper">

				<div class="slider-wrapper">

					<label>{{ trans('idea_form.duration_label') }}</label>

					<input type="hidden" name="duration" id="duration-slider" value="{{ isset($idea) ? old('duration', $idea->duration) : old('duration', 30) }}">

					<div class="slider" id="idea-duration-slider" data-input-id="duration-slider" data-value="{{ isset($idea) ? old('duration', $idea->duration) : old('duration', 30) }}"></div>

				</div>

				@if ($errors->has('duration'))
					<span class="help-block">
						<strong>{{ $errors->first('duration') }}</strong>
					</span>
				@endif

			</div>

		@endif

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
			<button class="btn btn-primary" type="submit">{{ ($editing) ? trans('idea_form.save_changes') : trans('idea_form.create_idea') }}</button>
		</div>

		<a class="step-button muted-link" onClick="showStep('previous')">{{ trans('idea_form.previous_step') }}</a>

	</div>

</div>
