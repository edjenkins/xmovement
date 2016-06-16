<form class="{{ $errors->isEmpty() ? '' : ' has-errors' }}" role="form" method="POST" action="{{ $editing ? '/design/requirement/update' : '/design/requirement/store' }}">
    {!! csrf_field() !!}

    @if ($editing)
        <input type="hidden" name="id" value="{{ $requirement->id }}">
    @endif

    <input type="hidden" name="idea_id" value="{{ $idea->id }}">
    <input type="hidden" name="voting_type" value="standard">
    <input type="hidden" name="contribution_type" value="text">

    <div class="form-page visible">

        <div class="form-page-content">

            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">

                <label>{{ trans('xmovement_requirement_form.name_label') }}</label>

                <input type="text" class="form-control" name="name" value="{{ isset($requirement) ? old('name', $requirement->name) : old('name') }}" placeholder="{{ trans('xmovement_requirement_form.name_placeholder') }}">

                @if ($errors->has('name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                @endif

            </div>

            <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">

                <label>{{ trans('xmovement_requirement_form.description_label') }}</label>

                <input type="text" class="form-control" name="description" value="{{ isset($requirement) ? old('description', $requirement->description) : old('description') }}" placeholder="{{ trans('xmovement_requirement_form.description_placeholder') }}">

                @if ($errors->has('description'))
                    <span class="help-block">
                        <strong>{{ $errors->first('description') }}</strong>
                    </span>
                @endif

            </div>

			@include('forms/components/pin-toggle', ['label' => trans('xmovement_requirement_form.pinned_label'), 'design_task' => (isset($requirement) ? ((method_exists($requirement, 'design_task')) ? $requirement->design_task() : NULL) : NULL) , 'idea' => $idea, 'errors' => $errors])

            <hr />

            <br />

            <div class="form-group{{ $errors->has('item') ? ' has-error' : '' }}">

                <label>{{ trans('xmovement_requirement_form.item_label') }}</label>

                <input type="text" class="form-control" name="item" value="{{ isset($requirement) ? old('item', $requirement->item) : old('item') }}" placeholder="{{ trans('xmovement_requirement_form.item_placeholder') }}">

                @if ($errors->has('item'))
                    <span class="help-block">
                        <strong>{{ $errors->first('item') }}</strong>
                    </span>
                @endif

            </div>

            <div class="form-group{{ $errors->has('count') ? ' has-error' : '' }}">

                <label>{{ trans('xmovement_requirement_form.count_label') }}</label>

                <input type="text" class="form-control" name="count" value="{{ isset($requirement) ? old('count', $requirement->count) : old('count') }}" placeholder="{{ trans('xmovement_requirement_form.count_placeholder') }}">

                @if ($errors->has('count'))
                    <span class="help-block">
                        <strong>{{ $errors->first('count') }}</strong>
                    </span>
                @endif

            </div>

            <div class="form-group">
                <button class="btn btn-primary" type="submit">{{ ($editing) ? trans('xmovement_requirement_form.save_changes') : trans('xmovement_requirement_form.create_requirement') }}</button>
            </div>

        </div>

    </div>

</form>
