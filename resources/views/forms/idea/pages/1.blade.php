<div class="form-page visible" id="form-page-1" data-title="{{ trans('idea_form.name_your_idea') }}">

	<div class="form-page-content">

		<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">

			<label>{{ trans('idea_form.name_label') }}</label>

			<input type="text" class="form-control" name="name" value="{{ isset($idea) ? old('name', $idea->name) : old('name') }}" placeholder="{{ trans('idea_form.name_placeholder') }}">

			@if ($errors->has('name'))
				<span class="help-block">
					<strong>{{ $errors->first('name') }}</strong>
				</span>
			@endif

		</div>

		<div class="form-group">
			<div class="btn btn-primary step-button" onClick="nextStep()">{{ trans('idea_form.next_step') }}</div>
		</div>

	</div>

</div>
