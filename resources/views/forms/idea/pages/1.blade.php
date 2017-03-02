<div class="form-page animated visible" id="form-page-1" data-title="{{ trans('idea_form.name_your_idea') }}">

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

		<div class="form-group{{ $errors->has('parent_category') ? ' has-error' : '' }}">

			<label>Primary Category</label>

			<input type="hidden" name="primary_category" id="primary-category-field" value="{{ isset($idea) ? old('primary_category', $idea->primary_category) : old('primary_category') }}">

			<ul class="category-pills">
				@foreach ($primary_categories as $primary_category)

					<li class="category-pill primary-category-pill {{ ($primary_category == (isset($idea) ? old('primary_category', $idea->primary_category) : old('primary_category')) ? 'active' : '') }}" data-primary-category-id="{{ $primary_category->id }}">{{ $primary_category->name }}</li>

				@endforeach
			</ul>

			@if ($errors->has('primary_category'))
				<span class="help-block">
					<strong>{{ $errors->first('primary_category') }}</strong>
				</span>
			@endif

		</div>

		<div class="form-group{{ $errors->has('secondary_category') ? ' has-error' : '' }}">

			<label>Secondary Category</label>

			<input type="hidden" name="secondary_category" id="secondary-category-field" value="{{ isset($idea) ? old('secondary_category', $idea->secondary_category) : old('secondary_category') }}">

			<ul class="category-pills">
				@foreach ($secondary_categories as $secondary_category)

					<li class="category-pill secondary-category-pill {{ ($secondary_category == (isset($idea) ? old('secondary_category', $idea->secondary_category) : old('secondary_category')) ? 'active' : '') }}" data-secondary-category-id="{{ $secondary_category->id }}">{{ $secondary_category->name }}</li>

				@endforeach
			</ul>

			@if ($errors->has('secondary_category'))
				<span class="help-block">
					<strong>{{ $errors->first('secondary_category') }}</strong>
				</span>
			@endif

		</div>

		<div class="form-group">
			<div class="btn btn-primary step-button" onClick="showStep('next')">{{ trans('idea_form.next_step') }}</div>
		</div>

	</div>

</div>


<script type="text/javascript">

	var primary_category = $('#primary-category-field').val();
	var secondary_category = $('#secondary-category-field').val();

	$('ul.category-pills li.primary-category-pill').on('click', function() {

		$('ul.category-pills li.primary-category-pill').removeClass('active');
		$(this).addClass('active');

		$('#primary-category-field').val($(this).attr('data-primary-category-id'));
	});

	$('ul.category-pills li.secondary-category-pill').on('click', function() {

		$('ul.category-pills li.secondary-category-pill').removeClass('active');
		$(this).addClass('active');

		$('#secondary-category-field').val($(this).attr('data-secondary-category-id'));
	});

</script>
