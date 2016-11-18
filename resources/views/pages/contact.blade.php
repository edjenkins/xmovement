@extends('layouts.app', ['bodyclasses' => 'transparent medium-grey'])

@section('content')
    <div class="container-fluid hero-container" id="contact-hero-container" style="background-image:url('{{ getenv('APP_CONTACT_HEADER_IMG') }}')">
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

	<div class="container">

		<div class="row contact-row">

			<div class="col-md-8 col-sm-6">
				<div class="contact-tile">
					<h3>
						{{ trans('contact.send_us_an_email') }}
					</h3>

				    <form class="auth-form" role="form" method="POST" action="{{ action('ContactController@send') }}">
				        {!! csrf_field() !!}

				        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
				            <label class="control-label">{{ trans('auth.name') }}</label>

				            @if ($errors->has('name'))
				                <span class="help-block">
				                    <strong>{{ $errors->first('name') }}</strong>
				                </span>
				            @endif

							@if (Auth::guest())
					            <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="{{ trans('auth.name') }}">
							@else
								<input type="text" class="form-control" name="name" value="{{ Auth::user()->name }}" placeholder="{{ trans('auth.name') }}">
							@endif
				        </div>

				        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
				            <label class="control-label">{{ trans('auth.email_address') }}</label>

				            @if ($errors->has('email'))
				                <span class="help-block">
				                    <strong>{{ $errors->first('email') }}</strong>
				                </span>
				            @endif

							@if (Auth::guest())
					            <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="{{ trans('auth.email') }}">
							@else
								<input type="email" class="form-control" name="email" value="{{ Auth::user()->email }}" placeholder="{{ trans('auth.email') }}">
							@endif
				        </div>

						<div class="form-group{{ $errors->has('text') ? ' has-error' : '' }}">
				            <label class="control-label">{{ trans('contact.your_message') }}</label>

				            @if ($errors->has('text'))
				                <span class="help-block">
				                    <strong>{{ $errors->first('text') }}</strong>
				                </span>
				            @endif

							<textarea class="expanding" name="text" rows="4">{{ old('text') }}</textarea>
						</div>

				        <button type="submit" class="btn btn-primary">
			                Send Message
			            </button>

				    </form>

				</div>
			</div>

			<div class="col-md-4 col-sm-6">
				<div class="faq-tile">
					<h3>
						FAQ
					</h3>

					<h4>{{ trans('faq.first_question') }}</h4>
					<p>{{ trans('faq.first_answer') }}</p>

					<h4>{{ trans('faq.second_question') }}</h4>
					<p>{{ trans('faq.second_answer') }}</p>

					<h4>{{ trans('faq.third_question') }}</h4>
					<p>{{ trans('faq.third_answer') }}</p>

				</div>
			</div>

		</div>

	</div>
@endsection
