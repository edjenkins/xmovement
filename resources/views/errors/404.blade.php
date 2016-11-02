@extends('layouts.error', ['bodyclasses' => 'colorful'])

@section('content')

    <div class="container-fluid error-page">

		<div class="logo-container">
			<img class="logo-white" src="{{ asset(env('S3_URL') . '/logos/logo-white.png') }}" alt="{{ trans('common.brand') }}" />
		</div>
		
        <div class="text-container">
            <h1>{{ trans('errors.404') }}</h1>
			<h3>{{ trans('errors.page_not_found') }}</h3>
			<a href="{{ action('PageController@home') }}">
				{{ trans('errors.return_to_home') }}
			</a>
        </div>

    </div>

@endsection
