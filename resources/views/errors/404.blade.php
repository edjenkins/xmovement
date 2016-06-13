@extends('layouts.error', ['bodyclasses' => 'colorful'])

@section('content')

    <div class="container-fluid error-page">

        <div class="text-container">
            <h1>404</h1>
			<h3>Not Found</h3>
			<a href="{{URL::previous()}}">
				<i class="fa fa-angle-left"></i>
			</a>
        </div>

    </div>

@endsection
