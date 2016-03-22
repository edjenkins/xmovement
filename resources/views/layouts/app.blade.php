<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>XM</title>

    <!-- Fonts -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700" rel='stylesheet' type='text/css'>

    <!-- JavaScripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    
    <!-- Styles -->
    <link href="/css/app.css" rel="stylesheet">
</head>
<body class="fade-nav {{ $bodyclasses or '' }}" id="app-layout">
    
    @include('facebook-sdk')

    @include('navbar')

    @if ( Session::has('flash_message') )
 
        <div class="flash {{ Session::get('flash_type') }}">
            {{ Session::get('flash_message') }}
        </div>
      
    @endif

    @yield('content')

    @include('footer')

    @include('modals/auth')

    <!-- JavaScripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

    <script src="https://www.google.com/recaptcha/api.js"></script>
    
    <script src='/js/file_uploader/vendor/jquery.ui.widget.js'></script>
    <script src='/js/file_uploader/jquery.iframe-transport.js'></script>
    <script src='/js/file_uploader/jquery.fileupload.js'></script>

    <script src="/js/app.js"></script>
</body>
</html>