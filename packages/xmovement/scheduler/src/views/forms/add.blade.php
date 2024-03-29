<form class="{{ $errors->isEmpty() ? '' : ' has-errors' }}" role="form" method="POST" action="{{ $editing ? '/design/scheduler/update' : '/design/scheduler/store' }}">
    {!! csrf_field() !!}

    @if ($editing)
        <input type="hidden" name="id" value="{{ $scheduler->id }}">
    @endif

    <input type="hidden" name="idea_id" value="{{ $idea->id }}">
    <input type="hidden" name="voting_type" value="boolean">

    <div class="form-page visible">

        <div class="form-page-content">

            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">

                <label>{{ trans('xmovement_scheduler_form.name_label') }}</label>

                <input type="text" class="form-control" name="name" value="{{ isset($scheduler) ? old('name', $scheduler->name) : old('name') }}" placeholder="{{ trans('xmovement_scheduler_form.name_placeholder') }}">

                @if ($errors->has('name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                @endif

            </div>

            <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">

                <label>{{ trans('xmovement_scheduler_form.description_label') }}</label>

                <input type="text" class="form-control" name="description" value="{{ isset($scheduler) ? old('description', $scheduler->description) : old('description') }}" placeholder="{{ trans('xmovement_scheduler_form.description_placeholder') }}">

                @if ($errors->has('description'))
                    <span class="help-block">
                        <strong>{{ $errors->first('description') }}</strong>
                    </span>
                @endif

            </div>

			@include('forms/components/pin-toggle', ['label' => trans('xmovement_scheduler_form.pinned_label'), 'design_task' => (isset($scheduler) ? ((method_exists($scheduler, 'design_task')) ? $scheduler->design_task() : NULL) : NULL) , 'idea' => $idea, 'errors' => $errors])

			@include('forms/components/lock-toggle', ['label' => trans('xmovement_scheduler_form.locked_label'), 'design_task' => (isset($scheduler) ? ((method_exists($scheduler, 'design_task')) ? $scheduler->design_task() : NULL) : NULL) , 'idea' => $idea, 'errors' => $errors])

            <div class="form-group">
                <button class="btn btn-primary" type="submit">{{ ($editing) ? trans('xmovement_scheduler_form.save_changes') : trans('xmovement_scheduler_form.create_scheduler') }}</button>
            </div>

        </div>

    </div>

</form>
