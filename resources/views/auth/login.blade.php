@extends('layouts.app', ['bodyclasses' => 'colorful'])

@section('content')

    <div class="page-header">
        
        <h2 class="main-title">Log In</h2>

    </div>

    <div class="container">
        <div class="row">
            
            <div class="auth-panel">

                @include('forms/login')
            
            </div>
        </div>
    </div>

@endsection
