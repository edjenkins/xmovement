
@extends('layouts.app')

@section('content')

    <div class="page-header">

        <h2 class="main-title" id="page-title">{{ $errors->isEmpty() ? trans('idea_form.name_your_idea') : trans('idea_form.create_idea') }}</h2>

    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">

                @include('forms/idea', ['editing' => false])

            </div>
        </div>
    </div>

    <script src="/js/ideas/add.js"></script>

@endsection
