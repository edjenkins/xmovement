@extends('layouts.app')

@section('content')

	<div class="fluid-row profile-header"></div>

	<div class="container">
		
		<div class="row">

			@include('users.profile-side-column')

			@include('users.profile-main-column')
	
		</div>
	
	</div>

@endsection