<form class="{{ $errors->isEmpty() ? '' : ' has-errors' }}" role="form" method="POST" action="{{ $editing ? '/design/contribution/update' : '/design/contribution/store' }}">
    {!! csrf_field() !!}

    @if ($editing)
        <input type="hidden" name="id" value="{{ $contribution->id }}">
    @endif

    <input type="hidden" name="idea_id" value="{{ $idea->id }}">
    <input type="hidden" name="voting_type" value="standard">
    <input type="hidden" name="contribution_type" value="text">

    <div class="form-page visible">

        <div class="form-page-content">

            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">

                <label>{{ trans('xmovement_contribution_form.name_label') }}</label>

                <input type="text" class="form-control" name="name" value="{{ isset($contribution) ? old('name', $contribution->name) : old('name') }}" placeholder="{{ trans('xmovement_contribution_form.name_placeholder') }}">

                @if ($errors->has('name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                @endif

            </div>

            <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">

                <label>{{ trans('xmovement_contribution_form.description_label') }}</label>

                <input type="text" class="form-control" name="description" value="{{ isset($contribution) ? old('description', $contribution->description) : old('description') }}" placeholder="{{ trans('xmovement_contribution_form.description_placeholder') }}">

                @if ($errors->has('description'))
                    <span class="help-block">
                        <strong>{{ $errors->first('description') }}</strong>
                    </span>
                @endif

            </div>

			@include('forms/components/pin-toggle', ['label' => trans('xmovement_contribution_form.pinned_label'), 'design_task' => (isset($contribution) ? ((method_exists($contribution, 'design_task')) ? $contribution->design_task() : NULL) : NULL) , 'idea' => $idea, 'errors' => $errors])

			@include('forms/components/lock-toggle', ['label' => trans('xmovement_contribution_form.locked_label'), 'design_task' => (isset($contribution) ? ((method_exists($contribution, 'design_task')) ? $contribution->design_task() : NULL) : NULL) , 'idea' => $idea, 'errors' => $errors])

            <hr />

            <br />

            <div class="form-group{{ $errors->has('item') ? ' has-error' : '' }}">

                <label>{{ trans('xmovement_contribution_form.type_label') }}</label>

                <input type="hidden" id="contribution-type" name="contribution_type" value="1">

                <select>
                    <option value="1">Text</option>
                    <option value="2">Image</option>
                    <option value="3">Video</option>
                    <option value="4">File</option>
                </select>

            </div>

            <div class="form-group">
                <button class="btn btn-primary" type="submit">{{ ($editing) ? trans('xmovement_contribution_form.save_changes') : trans('xmovement_contribution_form.create_contribution') }}</button>
            </div>

        </div>

    </div>

</form>
