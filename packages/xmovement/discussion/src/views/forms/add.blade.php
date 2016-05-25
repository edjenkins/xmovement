<form class="{{ $errors->isEmpty() ? '' : ' has-errors' }}" role="form" method="POST" action="{{ $editing ? '/design/discussion/update' : '/design/discussion/store' }}">
    {!! csrf_field() !!}

    @if ($editing)
        <input type="hidden" name="id" value="{{ $discussion->id }}">
    @endif

    <input type="hidden" name="idea_id" value="{{ $idea->id }}">
    <input type="hidden" name="voting_type" value="standard">
    <input type="hidden" name="contribution_type" value="text">

    <div class="form-page visible">

        <div class="form-page-content">

            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">

                <label>{{ trans('xmovement_discussion_form.name_label') }}</label>

                <input type="text" class="form-control" name="name" value="{{ isset($poll) ? old('name', $poll->name) : old('name') }}" placeholder="{{ trans('xmovement_discussion_form.name_placeholder') }}">

                @if ($errors->has('name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                @endif
            
            </div>

            <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">

                <label>{{ trans('xmovement_discussion_form.description_label') }}</label>

                <input type="text" class="form-control" name="description" value="{{ isset($poll) ? old('description', $poll->description) : old('description') }}" placeholder="{{ trans('xmovement_discussion_form.description_placeholder') }}">

                @if ($errors->has('description'))
                    <span class="help-block">
                        <strong>{{ $errors->first('description') }}</strong>
                    </span>
                @endif
            
            </div>

            <div class="form-group{{ $errors->has('locked') ? ' has-error' : '' }}">

                <div class="toggle-switch-wrapper">

                    <label>{{ trans('xmovement_discussion_form.locked_label') }}</label>

                    <label class="toggle-switch">

                        <input type="hidden" class="form-control" name="locked" id="locked-input" value="{{ isset($poll) ? old('locked', $poll->locked) : old('locked', 0) }}">
                        @if (isset($poll))
                            <div class="toggle-button{{ (old('locked', $poll->locked) == 1) ? ' checked' : '' }}" id="locked-toggle-button" onClick="$(this).toggleClass('checked'); $('#locked-input').attr('value', $(this).hasClass('checked') ? 1 : 0);"></div>
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

            <div class="form-group">
                <button class="btn btn-primary" type="submit">{{ ($editing) ? trans('xmovement_discussion_form.save_changes') : trans('xmovement_discussion_form.create_discussion') }}</button>
            </div>
            
        </div>

    </div>

</form>