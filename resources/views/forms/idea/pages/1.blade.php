<div class="form-page animated visible" id="form-page-1" data-title="{{ trans('idea_form.name_your_idea') }}" ng-controller="CreateIdeaController">

	<div class="form-page-content">

		<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">

			<label>{{ trans('idea_form.name_label') }}</label>

			<textarea class="expanding text-center" name="name" rows="1" placeholder="{{ trans('idea_form.name_placeholder') }}">{{ isset($idea) ? old('name', $idea->name) : old('name') }}</textarea>

			@if ($errors->has('name'))
				<span class="help-block">
					<strong>{{ $errors->first('name') }}</strong>
				</span>
			@endif

		</div>

		@if(DynamicConfig::fetchConfig('CATEGORIES_ENABLED', false))

			<div class="form-group{{ $errors->has('category') ? ' has-error' : '' }}">

				<label>{{ trans('idea_form.category_label') }}</label>

				<div class="category-picker-wrapper">
					<category-picker populated-only="false" category="{{ isset($idea) ? $idea->category : NULL }}"></category-picker>
				</div>

				@if ($errors->has('category'))
					<span class="help-block">
						<strong>{{ $errors->first('category') }}</strong>
					</span>
				@endif

			</div>

		@endif

		<div class="form-group">
			<div class="btn btn-primary step-button" onClick="showStep('next')">{{ trans('idea_form.next_step') }}</div>
		</div>

	</div>

</div>
