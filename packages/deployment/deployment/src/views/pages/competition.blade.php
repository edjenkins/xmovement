@extends('layouts.app', ['bodyclasses' => 'transparent grey'])

@section('content')
    <div class="container-fluid hero-container" id="about-hero-container" style="background-image:url('{{ getenv('APP_ABOUT_HEADER_IMG') }}')">
        <div class="black-overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="text-container">
                        Competition
                    </div>
                </div>
            </div>
        </div>
	</div>
@endsection
