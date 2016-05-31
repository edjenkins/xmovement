<form class="proposal-form" role="form" method="POST" action="{{ url('/proposal/add') }}">
    {!! csrf_field() !!}

    <div class="form-group{{ $errors->has('body') ? ' has-error' : '' }}">
        <label class="control-label">Your Proposal</label>

				<textarea name="body" rows="20" placeholder="Proposal..."></textarea>
        <!-- <input type="email" class="form-control input-field" name="email" value="{{ old('email') }}" > -->

        @if ($errors->has('body'))
            <span class="help-block">
                <strong>{{ $errors->first('body') }}</strong>
            </span>
        @endif

    </div>

    <div class="form-group">

        <button type="submit" class="btn btn-primary">
            Submit Proposal
        </button>

        <br />

        <a class="btn btn-link muted-link" href="{{ url('/proposal/save') }}">Save for later</a>

    </div>

</form>
