
@extends('layouts.app')

@section('content')

    <div class="page-header">
        
        <h2 class="main-title" id="page-title">Name your idea</h2>

    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <form class="add-idea-form{{ $errors->isEmpty() ? '' : ' has-errors' }}" role="form" method="POST" action="{{ action('IdeaController@update', $idea->id) }}">
                    {!! csrf_field() !!}

                    <input type="hidden" name="id" value="{{ $idea->id }}">

                    <div class="form-page visible" id="form-page-1">

                        <div class="form-page-content">

                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">

                                <label>Choose a name that is short but self explanatory e.g. Open Python Class</label>

                                <input type="text" class="form-control" name="name" value="{{ old('name', $idea->name) }}" placeholder="Idea name">

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            
                            </div>

                            <div class="form-group">
                                <div class="btn btn-primary step-button" data-step="2">Next Step</div>
                            </div>

                            <hr />

                        </div>

                    </div>

                    <div class="form-page <?php if (!$errors->isEmpty()) { echo 'visible'; } ?>" id="form-page-2">

                        <div class="form-page-content">

                            <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">

                                <label>Add a short description of your idea, this should include the expected outcomes</label>

                                <textarea name="description" value="{{ $idea->description }}" rows="4"></textarea>

                                @if ($errors->has('description'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif

                            </div>

                            <div class="form-group">
                                <div class="btn btn-primary step-button" data-step="3">Next Step</div>
                            </div>
                            
                            <a class="step-button muted-link" data-step="1">Previous Step</a>

                            <hr />

                        </div>

                    </div>

                    <div class="form-page <?php if (!$errors->isEmpty()) { echo 'visible'; } ?>" id="form-page-3">

                        <div class="form-page-content">

                            <div class="form-group{{ $errors->has('photo') ? ' has-error' : '' }}">
                            
                                <label>Bring some life to your idea by adding a photo</label>

                                @include('fileupload', ['cc' => true, 'value' => old('photo', $idea->photo)])

                                @if ($errors->has('photo'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('photo') }}</strong>
                                    </span>
                                @endif

                            </div>

                            <div class="form-group">
                                <button class="btn btn-primary" type="submit">Save Changes</button>
                            </div>
                            
                            <a class="step-button muted-link" data-step="2">Previous Step</a>

                        </div>

                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
