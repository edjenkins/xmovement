@extends('layouts.error', ['bodyclasses' => 'colorful'])

@section('content')

    <div class="container-fluid error-page">

        <div class="text-container">
            <h1>{{ trans('errors.503') }}</h1>
			<h3>{{ trans('errors.service_unavailable') }}</h3>
        </div>

    </div>

@endsection
