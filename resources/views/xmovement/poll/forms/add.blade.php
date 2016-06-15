<form class="{{ $errors->isEmpty() ? '' : ' has-errors' }}" role="form" method="POST" action="{{ $editing ? '/design/poll/update' : '/design/poll/store' }}">
    {!! csrf_field() !!}

    @if ($editing)
        <input type="hidden" name="id" value="{{ $poll->id }}">
    @endif

    <input type="hidden" name="idea_id" value="{{ $idea->id }}">
    <input type="hidden" name="voting_type" value="standard">
    <input type="hidden" name="contribution_type" value="text">

    <div class="form-page visible">

        <div class="form-page-content">

            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">

                <label>{{ trans('xmovement_poll_form.name_label') }}</label>

                <input type="text" class="form-control" name="name" value="{{ isset($poll) ? old('name', $poll->name) : old('name') }}" placeholder="{{ trans('xmovement_poll_form.name_placeholder') }}">

                @if ($errors->has('name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                @endif

            </div>

            <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">

                <label>{{ trans('xmovement_poll_form.description_label') }}</label>

                <input type="text" class="form-control" name="description" value="{{ isset($poll) ? old('description', $poll->description) : old('description') }}" placeholder="{{ trans('xmovement_poll_form.description_placeholder') }}">

                @if ($errors->has('description'))
                    <span class="help-block">
                        <strong>{{ $errors->first('description') }}</strong>
                    </span>
                @endif

            </div>

			@include('forms/components/pin-toggle', ['design_task' => (isset($poll) ? ((method_exists($poll, 'design_task')) ? $poll->design_task() : NULL) : NULL) , 'idea' => $idea, 'errors' => $errors])

			@include('forms/components/lock-toggle', ['design_task' => (isset($poll) ? ((method_exists($poll, 'design_task')) ? $poll->design_task() : NULL) : NULL) , 'idea' => $idea, 'errors' => $errors])
			
            <div class="form-group">
                <button class="btn btn-primary" type="submit">{{ ($editing) ? trans('xmovement_poll_form.save_changes') : trans('xmovement_poll_form.create_poll') }}</button>
            </div>

        </div>

    </div>

</form>
