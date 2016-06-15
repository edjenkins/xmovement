<form class="{{ $errors->isEmpty() ? '' : ' has-errors' }}" role="form" method="POST" action="{{ $editing ? '/design/external/update' : '/design/external/store' }}">
    {!! csrf_field() !!}

    @if ($editing)
        <input type="hidden" name="id" value="{{ $external->id }}">
    @endif

    <input type="hidden" name="idea_id" value="{{ $idea->id }}">

    <div class="form-page visible">

        <div class="form-page-content">

            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">

                <label>{{ trans('xmovement_external_form.name_label') }}</label>

                <input type="text" class="form-control" name="name" value="{{ isset($external) ? old('name', $external->name) : old('name') }}" placeholder="{{ trans('xmovement_external_form.name_placeholder') }}">

                @if ($errors->has('name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                @endif

            </div>

            <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">

                <label>{{ trans('xmovement_external_form.description_label') }}</label>

                <input type="text" class="form-control" name="description" value="{{ isset($external) ? old('description', $external->description) : old('description') }}" placeholder="{{ trans('xmovement_external_form.description_placeholder') }}">

                @if ($errors->has('description'))
                    <span class="help-block">
                        <strong>{{ $errors->first('description') }}</strong>
                    </span>
                @endif

            </div>

			@include('forms/components/pin-toggle', ['design_task' => (isset($external) ? ((method_exists($external, 'design_task')) ? $external->design_task() : NULL) : NULL) , 'idea' => $idea, 'errors' => $errors])

			<hr />

			<br />

            <div class="form-group{{ $errors->has('embed_code') ? ' has-error' : '' }}">

                <label>{{ trans('xmovement_external_form.embed_code_label') }}</label>

                <input type="text" class="form-control" name="embed_code" value="{{ isset($external) ? old('embed_code', $external->embed_code) : old('embed_code') }}" placeholder="{{ trans('xmovement_external_form.embed_code_placeholder') }}">

                @if ($errors->has('embed_code'))
                    <span class="help-block">
                        <strong>{{ $errors->first('embed_code') }}</strong>
                    </span>
                @endif

            </div>

			<p>
				or
			</p>

			<div class="form-group{{ $errors->has('external_link') ? ' has-error' : '' }}">

					<label>{{ trans('xmovement_external_form.external_link_label') }}</label>

					<input type="text" class="form-control" name="external_link" value="{{ isset($external) ? old('external_link', $external->external_link) : old('external_link') }}" placeholder="{{ trans('xmovement_external_form.external_link_placeholder') }}">

					@if ($errors->has('external_link'))
							<span class="help-block">
									<strong>{{ $errors->first('external_link') }}</strong>
							</span>
					@endif

			</div>

            <div class="form-group">
                <button class="btn btn-primary" type="submit">{{ ($editing) ? trans('xmovement_external_form.save_changes') : trans('xmovement_external_form.create_external') }}</button>
            </div>

        </div>

    </div>

</form>
