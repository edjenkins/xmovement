<div class="form-page animated <?php if (!$errors->isEmpty()) { echo 'visible'; } ?>" id="form-page-4" data-title="{{ trans('idea_form.questions') }}">

	<div class="form-page-content">

		<div class="form-group">

			<label>{{ trans('idea_form.questions_label') }}</label>

			<div id="pre-populated-design-tasks">

				<?php $questions = isset($idea) ? old('questions', $idea->questions) : ((old('questions') != null) ? old('questions') : []); ?>

				<textarea class="expanding text-center" name="questions[0]" rows="1" placeholder="{{ trans('idea_form.question_1_placeholder') }}">{{ $questions[0] or '' }}</textarea>
				<textarea class="expanding text-center" name="questions[1]" rows="1" placeholder="{{ trans('idea_form.question_2_placeholder') }}">{{ $questions[1] or '' }}</textarea>
				<textarea class="expanding text-center" name="questions[2]" rows="1" placeholder="{{ trans('idea_form.question_3_placeholder') }}">{{ $questions[2] or '' }}</textarea>

			</div>

		</div>

		<div class="form-group">
			<div class="btn btn-primary step-button" onClick="showStep('next')">{{ trans('idea_form.next_step') }}</div>
		</div>

		<a class="step-button muted-link" onClick="showStep('previous')">{{ trans('idea_form.previous_step') }}</a>

	</div>

</div>
