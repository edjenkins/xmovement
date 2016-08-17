<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ MetaTag::get('title') }}</title>

    <!-- Fonts -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700" rel='stylesheet' type='text/css'>

    <!-- JavaScripts -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
	<script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>

    <!-- Styles -->
	<link href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css" rel="stylesheet">
	<link href="{{ URL::asset('css/bootstrap.min.css') }}" rel="stylesheet">
	<link href="{{ URL::asset('css/animate.min.css') }}" rel="stylesheet">
	<link href="{{ URL::asset('css/jquery-ui-slider-pips.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('css/easydropdown/easydropdown.css') }}" rel="stylesheet">
	<link href="{{ URL::asset('css/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('css/app.css') }}" rel="stylesheet">

    {!! MetaTag::tag('description') !!}
    {!! MetaTag::tag('image') !!}

    {!! MetaTag::openGraph() !!}

    {!! MetaTag::twitterCard() !!}

    {!! MetaTag::tag('image',  getenv('APP_HOME_HEADER_IMG')) !!}

	<!-- Begin Cookie Consent plugin by Silktide - http://silktide.com/cookieconsent -->
	<script type="text/javascript">
	    window.cookieconsent_options = {"message":"We use cookies to ensure you get the best experience on our website","dismiss":"Got It","learnMore":"","link":null,"theme":"light-floating"};
	</script>

	<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/1.0.10/cookieconsent.min.js"></script>
	<!-- End Cookie Consent plugin -->

</head>

<body class="fade-nav {{ $bodyclasses or '' }}" id="app-layout" ng-app="XMovement">

	@include('google-analytics', ['trackingId' => getenv('APP_GA_TRACKING_ID')])

    @include('facebook-sdk')

    @include('navbar')

    @if ( Session::has('flash_message') )

        <div class="flash {{ Session::get('flash_type') }}">
            {{ Session::get('flash_message') }}
			<div class="flash-dismiss" onClick="$(this).parent().fadeOut()">
				<i class="fa fa-times"></i>
			</div>
        </div>

    @endif

    @yield('content')

    @include('footer')

    @include('modals/auth')

    <!-- JavaScripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.7/angular.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.7/angular-route.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/ngStorage/0.3.6/ngStorage.min.js"></script>

	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

    <script src="https://www.google.com/recaptcha/api.js"></script>

	<script src="{{ URL::asset('js/expanding.js') }}"></script>

	<script src="{{ URL::asset('js/app.js') }}"></script>
	<script src="{{ URL::asset('js/vendor.js') }}"></script>
    <script src="{{ URL::asset('js/easydropdown/jquery.easydropdown.js') }}"></script>
	<script src="{{ URL::asset('css/bootstrap-daterangepicker/daterangepicker.js') }}"></script>

	<script src="{{ URL::asset('js/angular.js') }}"></script>

</body>
</html>
