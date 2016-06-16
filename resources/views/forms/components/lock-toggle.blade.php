@can('lockDesignTask', $idea)

	<div class="form-group{{ $errors->has('locked') ? ' has-error' : '' }}">

		<div class="toggle-switch-wrapper">

			<label>{{ $label }}</label>

			<label class="toggle-switch">

				<input type="hidden" class="form-control" name="locked" id="locked-input" value="{{ isset($design_task) ? old('locked', $design_task->locked) : old('locked', 0) }}">
				@if (isset($design_task))
					<div class="toggle-button{{ (old('locked', $design_task->locked) == 1) ? ' checked' : '' }}" id="locked-toggle-button" onClick="$(this).toggleClass('checked'); $('#locked-input').attr('value', $(this).hasClass('checked') ? 1 : 0);"></div>
				@else
					<div class="toggle-button{{ (old('locked', 0) == 1) ? ' checked' : '' }}" id="locked-toggle-button" onClick="$(this).toggleClass('checked'); $('#locked-input').attr('value', $(this).hasClass('checked') ? 1 : 0);"></div>
				@endif
			</label>

			<div class="clearfloat"></div>

		</div>

		@if ($errors->has('locked'))
			<span class="help-block">
				<strong>{{ $errors->first('locked') }}</strong>
			</span>
		@endif

	</div>

@endcan
