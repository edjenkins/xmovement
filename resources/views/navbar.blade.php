<nav class="navbar">
    <div class="container">
        <div class="navbar-header">

            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                <span class="sr-only">{{ trans('navbar.toggle') }}</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <a target="_self" class="navbar-brand" href="{{ url('/') }}">
				<img class="logo-color" src="{{ asset(env('S3_URL') . '/logos/logo.svg') }}" alt="{{ trans('common.brand') }}" />
				<img class="logo-white" src="{{ asset(env('S3_URL') . '/logos/logo-white.svg') }}" alt="{{ trans('common.brand') }}" />
            </a>

            <div class="clearfix"></div>
        </div>

        <div class="collapse navbar-collapse" id="app-navbar-collapse">

            <ul class="nav navbar-nav navbar-right">

				@if (DynamicConfig::fetchConfig('INSPIRATION_MODE_ENABLED', false))
					<li><a target="_self" href="{{ action('InspirationController@index') }}">{{ trans('navbar.inspiration') }}</a></li>
				@endif

				@if (DynamicConfig::fetchConfig('CREATION_MODE_ENABLED', true))
	                <li><a target="_self" href="{{ action('IdeaController@add') }}">{{ trans('navbar.create') }}</a></li>
				@endif

                <li><a target="_self" href="{{ action('IdeaController@index') }}">{{ trans('navbar.explore') }}</a></li>

				@foreach (Config::get('custom-pages.pages', []) as $index => $custom_page)
					@if($custom_page['nav'])
						<li>
							<a target="_self" href="{{ $custom_page['route'] }}">{{ $custom_page['name'] }}</a>
						</li>
					@endif
				@endforeach

                <li><a target="_self" href="{{ action('PageController@about') }}">{{ trans('navbar.about') }}</a></li>

                @if (Auth::guest())
                    <li><a target="_self" href="{{ action('Auth\AuthController@showLoginForm') }}">{{ trans('navbar.login') }}</a></li>
                    <li><a target="_self" href="{{ action('Auth\AuthController@showRegistrationForm') }}">{{ trans('navbar.register') }}</a></li>
                @else
                    <li class="dropdown">
                        <a target="_self" href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            {{ Auth::user()->name }}
							<i class="fa fa-fw fa-angle-down"></i>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            <li><a target="_self" href="{{ action('UserController@profile') }}"></i>{{ trans('navbar.profile') }}</a></li>
							@can('translate', Auth::user())
								<li><a target="_self" href="{{ action('TranslationController@index') }}"></i>{{ trans('navbar.translate') }}</a></li>
							@endcan
							@can('view_analytics', Auth::user())
								<li><a target="_self" href="{{ action('AnalyticsController@index') }}"></i>{{ trans('navbar.analytics') }}</a></li>
							@endcan
							@can('manage_platform', Auth::user())
								<li><a target="_self" href="{{ action('AdminController@managePlatform') }}"></i>{{ trans('navbar.manage_platform') }}</a></li>
							@endcan
							@can('manage_admins', Auth::user())
								<li><a target="_self" href="{{ action('AdminController@manageAdmins') }}"></i>{{ trans('navbar.manage_admins') }}</a></li>
							@endcan
							<li><a target="_self" href="{{ action('Auth\AuthController@logout') }}"></i>{{ trans('navbar.logout') }}</a></li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>
