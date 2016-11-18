<form class="{{ $errors->isEmpty() ? '' : ' has-errors' }}" role="form" method="POST" action="{{ $editing ? '/design/discussion/update' : '/design/discussion/store' }}">
    {!! csrf_field() !!}

    @if ($editing)
        <input type="hidden" name="id" value="{{ $discussion->id }}">
    @endif

    <input type="hidden" name="idea_id" value="{{ $idea->id }}">

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

            @include('forms/components/pin-toggle', ['label' => trans('xmovement_discussion_form.pinned_label'), 'design_task' => (isset($discussion) ? ((method_exists($discussion, 'design_task')) ? $discussion->design_task() : NULL) : NULL) , 'idea' => $idea, 'errors' => $errors])

            <div class="form-group">
                <button class="btn btn-primary" type="submit">{{ ($editing) ? trans('xmovement_discussion_form.save_changes') : trans('xmovement_discussion_form.create_discussion') }}</button>
            </div>

        </div>

    </div>

</form>
