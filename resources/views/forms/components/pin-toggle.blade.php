@can('pinDesignTask', $idea)

	<div class="form-group{{ $errors->has('pinned') ? ' has-error' : '' }}">

		<div class="toggle-switch-wrapper">

			<label>{{ trans('xmovement_contribution_form.pinned_label') }}</label>

			<label class="toggle-switch">

				<input type="hidden" class="form-control" name="pinned" id="pinned-input" value="{{ isset($design_task) ? old('pinned', $design_task->pinned) : old('pinned', 0) }}">
				@if (isset($design_task))
					<div class="toggle-button{{ (old('pinned', $design_task->pinned) == 1) ? ' checked' : '' }}" id="pinned-toggle-button" onClick="$(this).toggleClass('checked'); $('#pinned-input').attr('value', $(this).hasClass('checked') ? 1 : 0);"></div>
				@else
					<div class="toggle-button{{ (old('pinned', 0) == 1) ? ' checked' : '' }}" id="pinned-toggle-button" onClick="$(this).toggleClass('checked'); $('#pinned-input').attr('value', $(this).hasClass('checked') ? 1 : 0);"></div>
				@endif
			</label>

			<div class="clearfloat"></div>

		</div>

		@if ($errors->has('pinned'))
			<span class="help-block">
				<strong>{{ $errors->first('pinned') }}</strong>
			</span>
		@endif

	</div>

@endcan
