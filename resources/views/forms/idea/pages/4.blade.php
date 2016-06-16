<div class="form-page <?php if (!$errors->isEmpty()) { echo 'visible'; } ?>" id="form-page-4" data-title="{{ trans('idea_form.settings') }}">

	<div class="form-page-content">

		<div class="form-group{{ $errors->has('design_during_support') ? ' has-error' : '' }}">

			<div class="toggle-switch-wrapper">

				<label>{{ trans('idea_form.design_during_support_label') }}</label>

				<label class="toggle-switch">

					<input type="hidden" class="form-control" name="design_during_support" id="design-during-support-input" value="{{ isset($idea) ? old('design_during_support', $idea->design_during_support) : old('design_during_support', '0') }}">
					@if (isset($idea))
						<div class="toggle-button{{ (old('design_during_support', $idea->design_during_support) == '1') ? ' checked' : '' }}" id="design-during-support-toggle-button" onClick="$(this).toggleClass('checked'); $('#design-during-support-input').attr('value', $(this).hasClass('checked') ? '1' : '0');"></div>
					@else
						<div class="toggle-button{{ (old('design_during_support', '0') == '1') ? ' checked' : '' }}" id="design-during-support-toggle-button" onClick="$(this).toggleClass('checked'); $('#design-during-support-input').attr('value', $(this).hasClass('checked') ? '1' : '0');"></div>
					@endif
				</label>

				<div class="clearfloat"></div>

			</div>

			@if ($errors->has('design_during_support'))
				<span class="help-block">
					<strong>{{ $errors->first('design_during_support') }}</strong>
				</span>
			@endif

		</div>

		<div class="form-group{{ $errors->has('proposals_during_design') ? ' has-error' : '' }}">

			<div class="toggle-switch-wrapper">

				<label>{{ trans('idea_form.proposals_during_design_label') }}</label>

				<label class="toggle-switch">

					<input type="hidden" class="form-control" name="proposals_during_design" id="proposals-during-design-input" value="{{ isset($idea) ? old('proposals_during_design', $idea->proposals_during_design) : old('proposals_during_design', '0') }}">
					@if (isset($idea))
						<div class="toggle-button{{ (old('proposals_during_design', $idea->proposals_during_design) == '1') ? ' checked' : '' }}" id="proposals-during-design-toggle-button" onClick="$(this).toggleClass('checked'); $('#proposals-during-design-input').attr('value', $(this).hasClass('checked') ? '1' : '0');"></div>
					@else
						<div class="toggle-button{{ (old('proposals_during_design', '0') == '1') ? ' checked' : '' }}" id="proposals-during-design-toggle-button" onClick="$(this).toggleClass('checked'); $('#proposals-during-design-input').attr('value', $(this).hasClass('checked') ? '1' : '0');"></div>
					@endif
				</label>

				<div class="clearfloat"></div>

			</div>

			@if ($errors->has('proposals_during_design'))
				<span class="help-block">
					<strong>{{ $errors->first('proposals_during_design') }}</strong>
				</span>
			@endif

		</div>

		<div class="form-group">
			<div class="btn btn-primary step-button" onClick="nextStep()">{{ trans('idea_form.next_step') }}</div>
		</div>

		<a class="step-button muted-link" onClick="previousStep()">{{ trans('idea_form.previous_step') }}</a>

	</div>

</div>