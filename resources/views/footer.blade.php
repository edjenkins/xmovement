<footer class="footer">
    <div class="container-fluid">
        <div class="footer-content">
            <ul>
                <li>
                    <p>{{ trans('footer.brand') }}</p>
                </li>
                <li>
                    <a href="{{ action('PageController@contact') }}">{{ trans('footer.contact') }}</a>
                </li>
                <li>
                    <a href="{{ action('PageController@terms') }}">{{ trans('footer.terms') }}</a>
                </li>
                <li>
					@if (App::getLocale() == 'en')
	                    <a href="{{ action('PageController@home', ['locale' => 'null']) }}">{{ trans('footer.start_translating') }}</a>
					@else
						<a href="{{ action('PageController@home', ['locale' => 'en']) }}">{{ trans('footer.stop_translating') }}</a>
					@endif
                </li>
            </ul>
        </div>
    </div>
</footer>
