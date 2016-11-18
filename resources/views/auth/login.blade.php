@extends('layouts.app', ['bodyclasses' => 'colorful'])

@section('content')

    <div class="page-header colorful">

        <h2 class="main-title">{{ trans('auth.login') }}</h2>

    </div>

    <div class="container">
        <div class="row">

            <div class="auth-panel">

                @include('forms/login')

            </div>
        </div>
    </div>

@endsection
