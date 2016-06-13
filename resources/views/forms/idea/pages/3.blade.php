<div class="form-page <?php if (!$errors->isEmpty()) { echo 'visible'; } ?>" id="form-page-3" data-title="{{ trans('idea_form.add_a_photo') }}">

	<div class="form-page-content">

		<div class="form-group{{ $errors->has('photo') ? ' has-error' : '' }}">

			@if (isset($idea))
				@include('dropzone', ['type' => 'image', 'cc' => true, 'input_id' => 'idea-image', 'value' => old('photo', $idea->photo)])
			@else
				@include('dropzone', ['type' => 'image', 'cc' => true, 'input_id' => 'idea-image', 'value' => old('photo')])
			@endif

			@if ($errors->has('photo'))
				<span class="help-block">
					<strong>{{ $errors->first('photo') }}</strong>
				</span>
			@endif

		</div>

		<div class="form-group">

			@unless($editing)

				<div class="btn btn-primary step-button" onClick="nextStep()">{{ trans('idea_form.next_step') }}</div>

			@else

				<button class="btn btn-primary" type="submit">{{ ($editing) ? trans('idea_form.save_changes') : trans('idea_form.create_idea') }}</button>

			@endunless

		</div>

		<a class="step-button muted-link" onClick="previousStep()">{{ trans('idea_form.previous_step') }}</a>

	</div>

</div>
