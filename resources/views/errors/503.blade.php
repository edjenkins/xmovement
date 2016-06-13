@extends('layouts.error', ['bodyclasses' => 'colorful'])

@section('content')

    <div class="container-fluid error-page">

        <div class="text-container">
            <h1>503</h1>
			<h3>Service Unavailable</h3>
			<a href="{{action('PageController@home')}}">
				<i class="fa fa-home"></i>
			</a>
        </div>

    </div>

@endsection
