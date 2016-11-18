<div class="form-page animated <?php if (!$errors->isEmpty()) { echo 'visible'; } ?>" id="form-page-3" data-title="{{ trans('idea_form.add_a_photo') }}">

	<div class="form-page-content">

		<div class="form-group{{ $errors->has('photo') ? ' has-error' : '' }}">

			@if (isset($idea))
				@include('dropzone', ['type' => 'image', 'cc' => true, 'input_id' => 'photo', 'value' => old('photo', $idea->photo), 'dropzone_id' => 1])
			@else
				@include('dropzone', ['type' => 'image', 'cc' => true, 'input_id' => 'photo', 'value' => old('photo'), 'dropzone_id' => 1])
			@endif

			@if ($errors->has('photo'))
				<span class="help-block">
					<strong>{{ $errors->first('photo') }}</strong>
				</span>
			@endif

		</div>

		<div class="form-group">

			@if($editing)

				<button class="btn btn-primary" type="submit">{{ ($editing) ? trans('idea_form.save_changes') : trans('idea_form.create_idea') }}</button>

			@else

				<div class="btn btn-primary step-button" onClick="showStep('next')">{{ trans('idea_form.next_step') }}</div>

			@endif

		</div>

		<a class="step-button muted-link" onClick="showStep('previous')">{{ trans('idea_form.previous_step') }}</a>

	</div>

</div>
