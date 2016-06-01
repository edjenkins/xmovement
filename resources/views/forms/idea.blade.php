<form class="idea-form{{ $errors->isEmpty() ? '' : ' has-errors' }}" role="form" method="POST" action="{{ $editing ? action('IdeaController@update') : action('IdeaController@store') }}" data-current-step="1">
    {!! csrf_field() !!}

    @if ($editing)
        <input type="hidden" name="id" value="{{ $idea->id }}">
    @endif

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

            <div class="form-group">
                <div class="btn btn-primary step-button" onClick="nextStep()">{{ trans('idea_form.next_step') }}</div>
            </div>

        </div>

    </div>

    <div class="form-page <?php if (!$errors->isEmpty()) { echo 'visible'; } ?>" id="form-page-2" data-title="{{ trans('idea_form.describe_your_idea') }}">

        <div class="form-page-content">

            <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">

                <label>{{ trans('idea_form.description_label') }}</label>

                <textarea name="description" rows="4">{{ isset($idea) ? old('description', $idea->description) : old('description') }}</textarea>

                @if ($errors->has('description'))
                    <span class="help-block">
                        <strong>{{ $errors->first('description') }}</strong>
                    </span>
                @endif

            </div>

            <div class="form-group">
                <div class="btn btn-primary step-button" onClick="nextStep()">{{ trans('idea_form.next_step') }}</div>
            </div>

            <a class="step-button muted-link" onClick="previousStep()">{{ trans('idea_form.previous_step') }}</a>

        </div>

    </div>

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
                <button class="btn btn-primary" type="submit">{{ ($editing) ? trans('idea_form.save_changes') : trans('idea_form.create_idea') }}</button>
            </div>

            <a class="step-button muted-link" onClick="previousStep()">{{ trans('idea_form.previous_step') }}</a>

        </div>

    </div>

</form>
