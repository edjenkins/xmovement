@extends('layouts.app', ['bodyclasses' => 'transparent'])

@section('content')
    <div class="container-fluid hero-container" style="background-image:url('{{ getenv('APP_CONTACT_HEADER_IMG') }}')">
        <div class="black-overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="text-container">
                        <h1>{{ trans('contact.tagline') }}</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
