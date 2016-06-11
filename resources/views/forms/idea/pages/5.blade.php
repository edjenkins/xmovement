<div class="form-page <?php if (!$errors->isEmpty()) { echo 'visible'; } ?>" id="form-page-5" data-title="{{ trans('idea_form.timeframes') }}">

	<div class="form-page-content">

		<div class="form-group{{ $errors->has('supporters_target') ? ' has-error' : '' }}">

			<label>{{ trans('idea_form.supporters_target_label') }}</label>

			<input type="text" class="form-control" name="supporters_target" value="{{ isset($idea) ? old('supporters_target', $idea->supporters_target) : old('supporters_target') }}" placeholder="{{ trans('idea_form.supporters_target_placeholder') }}">

			@if ($errors->has('supporters_target'))
				<span class="help-block">
					<strong>{{ $errors->first('supporters_target') }}</strong>
				</span>
			@endif

		</div>

		<div class="form-group{{ $errors->has('duration') ? ' has-error' : '' }}" id="duration-slider-wrapper">

			<div class="slider-wrapper">

				<label>{{ trans('idea_form.duration_label') }}</label>

				<input type="hidden" name="duration" id="duration-slider" value="{{ isset($idea) ? old('duration', $idea->duration) : old('duration', 30) }}">

				<div class="slider" id="slider" data-input-id="duration-slider" data-value="{{ isset($idea) ? old('duration', $idea->duration) : old('duration', 30) }}"></div>

			</div>

			@if ($errors->has('duration'))
				<span class="help-block">
					<strong>{{ $errors->first('duration') }}</strong>
				</span>
			@endif

		</div>

		<div class="form-group">
			<button class="btn btn-primary" type="submit">{{ ($editing) ? trans('idea_form.save_changes') : trans('idea_form.create_idea') }}</button>
		</div>

		<a class="step-button muted-link" onClick="previousStep()">{{ trans('idea_form.previous_step') }}</a>

	</div>

</div>
