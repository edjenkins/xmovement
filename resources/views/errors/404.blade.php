@extends('layouts.error')

@section('content')

    <div class="container-fluid error-page">

        <div class="text-container">
            <h1>404</h1>
			<h3>Page Not Found</h3>
			<a href="{{ action('PageController@home') }}">
				Return to Home
			</a>
        </div>

    </div>

@endsection
