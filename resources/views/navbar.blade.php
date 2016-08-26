<nav class="navbar">
    <div class="container">
        <div class="navbar-header">

            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                <span class="sr-only">{{ trans('navbar.toggle') }}</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <a class="navbar-brand" href="{{ url('/') }}">
				<img class="logo-color" src="{{ asset(env('S3_URL') . '/logos/logo.png') }}" alt="{{ trans('common.brand') }}" />
				<img class="logo-white" src="{{ asset(env('S3_URL') . '/logos/logo-white.png') }}" alt="{{ trans('common.brand') }}" />
            </a>

            <div class="clearfix"></div>
        </div>

        <div class="collapse navbar-collapse" id="app-navbar-collapse">

            <ul class="nav navbar-nav navbar-right">

                <li><a href="{{ action('IdeaController@add') }}">{{ trans('navbar.create') }}</a></li>

				@if (env('IDEATION_PHASE_ENABLED'))
					<li><a href="{{ action('InspirationController@index') }}">{{ trans('navbar.inspiration') }}</a></li>
				@endif

                <li><a href="{{ action('IdeaController@index') }}">{{ trans('navbar.explore') }}</a></li>

                <li><a href="{{ action('PageController@about') }}">{{ trans('navbar.about') }}</a></li>

                @if (Auth::guest())
                    <li><a href="{{ action('Auth\AuthController@showLoginForm') }}">{{ trans('navbar.login') }}</a></li>
                    <li><a href="{{ action('Auth\AuthController@showRegistrationForm') }}">{{ trans('navbar.register') }}</a></li>
                @else
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{ action('UserController@profile') }}"></i>{{ trans('navbar.profile') }}</a></li>
							@can('translate', Auth::user())
								<li><a href="{{ action('TranslationController@index') }}"></i>{{ trans('navbar.translate') }}</a></li>
							@endcan
							@can('view_analytics', Auth::user())
								<li><a href="{{ action('AnalyticsController@index') }}"></i>{{ trans('navbar.analytics') }}</a></li>
							@endcan
							<li><a href="{{ action('Auth\AuthController@logout') }}"></i>{{ trans('navbar.logout') }}</a></li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>
