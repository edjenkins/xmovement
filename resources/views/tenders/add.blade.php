@extends('layouts.app')

@section('content')

	@include('grey-background')

	<div class="page-header">

	    <h2 class="main-title">{{ trans('tenders.submit_tender') }}</h2>
		<h5 class="sub-title"><a href="{{ action('IdeaController@view', $idea) }}">{{ $idea->name }}</a></h5>

	</div>

	<div class="white-controls-row">

		<div class="container">

			<div class="view-controls-container">

    			<ul class="module-controls pull-left">

					<li class="module-control">

						<a href="{{ action('IdeaController@view', $idea) }}">

	    					<i class="fa fa-chevron-left"></i>

	    					{{ trans('design.back_to_idea') }}

	    				</a>

    				</li>

    			</ul>

    			<div class="clearfloat"></div>

    		</div>

		</div>

	</div>

	<div class="container">

		<div class="col-sm-4 col-md-3 col-sm-push-8 col-md-push-9">

			<div class="side-panel tenders-side-panel">

				<div class="side-panel-box info-box">
					<div class="side-panel-box-header">
						Questions?
					</div>
					<div class="side-panel-box-content">
						<p>
							If you have any questions about the tender process, need help writing your tender or want to know what should be included please contact us below.
						</p>
						<a href="{{ action('PageController@contact') }}">
							<button class="btn" type="button" name="button">Contact Us</button>
						</a>
					</div>
				</div>

			</div>

		</div>

		<div class="col-sm-8 col-md-9 col-sm-pull-4 col-md-pull-3">

			<form class="auth-form tender-form" role="form" method="POST" action="{{ action('TenderController@submit') }}">
		        {!! csrf_field() !!}

				<input type="hidden" name="idea_id" value="{{ $idea->id }}">

		        <div class="form-group{{ $errors->has('company_name') ? ' has-error' : '' }}">
		            <label class="control-label">{{ trans('tender.company_name') }}</label>

		            <input type="text" class="form-control" name="company_name" value="{{ old('company_name') }}" placeholder="{{ trans('tender.company_name_placeholder') }}">

		            @if ($errors->has('company_name'))
		                <span class="help-block">
		                    <strong>{{ $errors->first('company_name') }}</strong>
		                </span>
		            @endif
		        </div>

		        <div class="form-group{{ $errors->has('contact_email_address') ? ' has-error' : '' }}">
		            <label class="control-label">{{ trans('tender.contact_email_address') }}</label>

		            <input type="email" class="form-control" name="contact_email_address" value="{{ old('contact_email_address') }}" placeholder="{{ trans('tender.contact_email_address_placeholder') }}">

		            @if ($errors->has('contact_email_address'))
		                <span class="help-block">
		                    <strong>{{ $errors->first('contact_email_address') }}</strong>
		                </span>
		            @endif
		        </div>

		        <div class="form-group{{ $errors->has('company_bio') ? ' has-error' : '' }}">
		            <label class="control-label">{{ trans('tender.company_bio') }}</label>

		            <textarea class="expanding" name="company_bio" rows="3" placeholder="{{ trans('tender.company_bio_placeholder') }}">{{ old('company_bio') }}</textarea>

		            @if ($errors->has('company_bio'))
		                <span class="help-block">
		                    <strong>{{ $errors->first('company_bio') }}</strong>
		                </span>
		            @endif
		        </div>

		        <div class="form-group{{ $errors->has('company_logo') ? ' has-error' : '' }}">
		            <label class="control-label">{{ trans('auth.company_logo') }}</label>

					@include('dropzone', ['type' => 'image', 'cc' => false, 'input_id' => 'company_logo', 'value' => old('company_logo'), 'dropzone_id' => 1])

		            @if ($errors->has('company_logo'))
		                <span class="help-block">
		                    <strong>{{ $errors->first('company_logo') }}</strong>
		                </span>
		            @endif
		        </div>

		        <div class="form-group{{ $errors->has('summary') ? ' has-error' : '' }}">
		            <label class="control-label">{{ trans('tender.summary') }}</label>

		            <textarea class="expanding" name="summary" rows="3" placeholder="{{ trans('tender.summary_placeholder') }}">{{ old('summary') }}</textarea>

		            @if ($errors->has('summary'))
		                <span class="help-block">
		                    <strong>{{ $errors->first('summary') }}</strong>
		                </span>
		            @endif
		        </div>

		        <div class="form-group">
		            <button type="submit" class="btn btn-primary pull-right">
		                {{ trans('tender.submit_tender') }}
		            </button>
					<div class="clearfloat">

					</div>
		        </div>

		    </form>

		</div>

    </div>

@endsection
