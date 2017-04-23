@extends('layouts.app')

@section('content')

	@include('grey-background')

	<div class="page-header colorful">

        <h2 class="main-title">{{ trans('proposals.review_proposal') }}</h2>
		<h5 class="sub-title">{{ trans('proposals.review_proposal_subtitle') }}</h5>

	</div>

	<div class="proposal-toolbar colorful">

		<a target="_self" href="{{ action('ProposalController@index', $idea) }}">
			<button class="next-button pull-left">
				{{ trans('proposals.cancel') }}
			</button>
		</a>

		<div class="clearfloat"></div>

	</div>

	<div class="container">

	    <div class="row">
			<div class="col-md-8 col-md-offset-2">

	    		<div class="column main-column proposal-preview-column">
					<form action="{{ action('ProposalController@submit', $idea) }}" method="POST" onsubmit="setOrder(); return confirm('{{ trans('proposals.submit_confirmation') }}');">
						{!! csrf_field() !!}
						<input type="hidden" name="proposal" id="proposal-input" value="">

						<ul class="proposal-preview" id="sortable">

							<li class="proposal-item user-header">
								<div class="avatar-wrapper">
									<div class="avatar" style="background-image: url('{{ ResourceImage::getProfileImage($user, 'medium') }}')"></div>
								</div>
							</li>

							<li class="proposal-item proposal-text-container">
								<h3>{{ trans('proposals.description') }}</h3>

								@if ($errors->has('description'))
									<span class="help-block">
										<strong>{{ $errors->first('description') }}</strong>
									</span>
								@endif

								<input type="text" name="description" placeholder="{{ trans('proposals.description_placeholder') }}" />
							</li>

							<li class="proposal-item upload-container proposal-file-container sortable" data-proposal-item-type="file" id="proposal-file-1">

								<h3>{{ trans('proposals.upload_document') }}</h3>
								@include('dropzone', ['type' => 'file', 'cc' => false, 'input_id' => 'proposal-file', 'dropzone_id' => 1])

							</li>

						</ul>

						<div class="add-content" id="add-content">
							<i class="fa fa-plus-circle fa-2x"></i>
						</div>

						<br />

						<button type="submit" type="button" class="btn btn-primary">
							{{ trans('proposals.submit_proposal') }}
						</button>
					</form>

	    		</div>

	    	</div>
	    </div>
	</div>

	<script src="/js/proposal/add.js"></script>

@endsection
