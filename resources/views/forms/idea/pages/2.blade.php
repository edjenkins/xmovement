<div class="form-page animated <?php if (!$errors->isEmpty()) { echo 'visible'; } ?>" id="form-page-2" data-title="{{ trans('idea_form.describe_your_idea') }}">

	<div class="form-page-content">

		<div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">

			<label>{{ trans('idea_form.description_label') }}</label>

			<textarea class="expanding text-center" name="description" rows="1" placeholder="{{ trans('idea_form.description_placeholder') }}">{{ isset($idea) ? old('description', $idea->description) : old('description') }}</textarea>

			@if ($errors->has('description'))
				<span class="help-block">
					<strong>{{ $errors->first('description') }}</strong>
				</span>
			@endif

		</div>

		<div class="form-group">
			<div class="btn btn-primary step-button" onClick="showStep('next')">{{ trans('idea_form.next_step') }}</div>
		</div>

		<a class="step-button muted-link" onClick="showStep('previous')">{{ trans('idea_form.previous_step') }}</a>

	</div>

</div>
