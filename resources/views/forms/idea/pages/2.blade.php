<div class="form-page <?php if (!$errors->isEmpty()) { echo 'visible'; } ?>" id="form-page-2" data-title="{{ trans('idea_form.describe_your_idea') }}">

	<div class="form-page-content">

		<div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">

			<label>{{ trans('idea_form.description_label') }}</label>

			<textarea name="description" rows="4">{{ isset($idea) ? old('description', $idea->description) : old('description') }}</textarea>

			@if ($errors->has('description'))
				<span class="help-block">
					<strong>{{ $errors->first('description') }}</strong>
				</span>
			@endif

		</div>

		<div class="form-group">
			<div class="btn btn-primary step-button" onClick="nextStep()">{{ trans('idea_form.next_step') }}</div>
		</div>

		<a class="step-button muted-link" onClick="previousStep()">{{ trans('idea_form.previous_step') }}</a>

	</div>

</div>
