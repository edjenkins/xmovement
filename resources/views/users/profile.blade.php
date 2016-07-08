@extends('layouts.app')

@section('content')

	<div class="fluid-row profile-header" style="background-image:url({{ ResourceImage::getImage($user->header, 'large') }})"></div>

	<div class="container">

		<div class="row">

			@include('users.profile-side-column')

			@include('users.profile-main-column')

		</div>

	</div>

	@include('modals/direct-message')

@endsection
