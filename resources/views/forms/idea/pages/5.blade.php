<div class="form-page animated <?php if (!$errors->isEmpty()) { echo 'visible'; } ?>" id="form-page-5" data-title="{{ trans('idea_form.settings') }}">

	<div class="form-page-content">

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

		<!-- Check if user can set duration of idea -->
		@if (DynamicConfig::fetchConfig('PROGRESSION_TYPE', 'fixed') == 'user-defined')

			<div class="form-group{{ $errors->has('duration') ? ' has-error' : '' }}" id="duration-wrapper" ng-init="duration = 'short'">

				<label>{{ trans('idea_form.duration_label') }}</label>

				<input type="hidden" class="form-control" name="duration" id="duration-input" ng-value="duration">

				<ul class="duration-selector">

					<li ng-show="{{ DynamicConfig::fetchConfig('SHORT_DURATION_ENABLED') }}">
						<button class="btn btn-default" ng-class="{'btn-primary':(duration == 'short')}" ng-click="duration = 'short'" type="button" name="button">Short ({{ (DynamicConfig::fetchConfig('SHORT_SUPPORT_DURATION') + DynamicConfig::fetchConfig('SHORT_DESIGN_DURATION')) }}d)</button>
					</li>
					<li ng-show="{{ DynamicConfig::fetchConfig('MEDIUM_DURATION_ENABLED') }}">
						<button class="btn btn-default" ng-class="{'btn-primary':(duration == 'medium')}" ng-click="duration = 'medium'" type="button" name="button">Medium ({{ (DynamicConfig::fetchConfig('MEDIUM_SUPPORT_DURATION') + DynamicConfig::fetchConfig('MEDIUM_DESIGN_DURATION')) }}d)</button>
					</li>
					<li ng-show="{{ DynamicConfig::fetchConfig('LONG_DURATION_ENABLED') }}">
						<button class="btn btn-default" ng-class="{'btn-primary':(duration == 'long')}" ng-click="duration = 'long'" type="button" name="button">Long ({{ (DynamicConfig::fetchConfig('LONG_SUPPORT_DURATION') + DynamicConfig::fetchConfig('LONG_DESIGN_DURATION')) }}d)</button>
					</li>

					<div class="clearfloat"></div>

				</ul>

				@if ($errors->has('duration'))
					<span class="help-block">
						<strong>{{ $errors->first('duration') }}</strong>
					</span>
				@endif

			</div>

		@endif

		<div class="form-group">
			<button class="btn btn-primary" type="submit">{{ ($editing) ? trans('idea_form.save_changes') : trans('idea_form.create_idea') }}</button>
		</div>

		<a class="step-button muted-link" onClick="showStep('previous')">{{ trans('idea_form.previous_step') }}</a>

	</div>

</div>
