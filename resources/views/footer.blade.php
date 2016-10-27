<footer class="footer">
    <div class="container-fluid">
        <div class="footer-content">
			<div class="container">
				<ul class="pull-left footer-links">
	                <li>
	                    <p>{{ trans('footer.brand') }}</p>
	                </li>

					@foreach (Config::get('custom-pages.pages') as $index => $custom_page)
						@if($custom_page['footer'])
							<li>
								<a href="{{ $custom_page['route'] }}">{{ $custom_page['name'] }}</a>
							</li>
						@endif
					@endforeach

	                <li>
	                    <a href="{{ action('PageController@contact') }}">{{ trans('footer.contact') }}</a>
	                </li>
	                <li>
	                    <a href="{{ action('PageController@terms') }}">{{ trans('footer.terms') }}</a>
	                </li>
	                <li>
	                    <a href="{{ action('PageController@terms', ['#privacy']) }}">{{ trans('footer.privacy') }}</a>
	                </li>
	            </ul>
	            <ul class="pull-right footer-logos">
					@if (env('FOOTER_LOGO_IMG_1'))
						<li>
							<a href="{{ env('FOOTER_LOGO_LINK_1') }}" target="_blank">
								<img src="{{ env('FOOTER_LOGO_IMG_1') }}" />
							</a>
						</li>
					@endif
					@if (env('FOOTER_LOGO_IMG_2'))
						<li>
							<a href="{{ env('FOOTER_LOGO_LINK_2') }}" target="_blank">
								<img src="{{ env('FOOTER_LOGO_IMG_2') }}" />
							</a>
						</li>
					@endif
					@if (env('FOOTER_LOGO_IMG_3'))
						<li>
							<a href="{{ env('FOOTER_LOGO_LINK_3') }}" target="_blank">
								<img src="{{ env('FOOTER_LOGO_IMG_3') }}" />
							</a>
						</li>
					@endif
					@if (env('FOOTER_LOGO_IMG_4'))
						<li>
							<a href="{{ env('FOOTER_LOGO_LINK_4') }}" target="_blank">
								<img src="{{ env('FOOTER_LOGO_IMG_4') }}" />
							</a>
						</li>
					@endif
				</ul>
			</div>
        </div>
    </div>
</footer>
