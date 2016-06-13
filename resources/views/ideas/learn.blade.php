@extends('layouts.app', ['bodyclasses' => 'colorful'])

@section('content')

    <div class="page-header colorful">

        <h2 class="main-title" id="page-title">Lets get started!</h2>

    </div>

    <div class="container">
        <div class="row">

            <div class="auth-panel">

                @include('forms/register', ['type' => 'quick'])

            </div>
        </div>
    </div>

@endsection
