@extends('layouts.app')

@section('content')

	@include('grey-background')

	<div class="page-header colorful">

        <h2 class="main-title">{{ trans('proposals.review_proposal') }}</h2>
		<h5 class="sub-title">{{ trans('proposals.review_proposal_subtitle') }}</h5>

	</div>

	<div class="proposal-toolbar colorful">

		<form action="{{ action('ProposeController@previous') }}" method="POST">
			{!! csrf_field() !!}
			<button class="previous-button pull-left" type="submit">
				{{ trans('proposals.previous') }}
			</button>
		</form>

		<div class="clearfloat"></div>

	</div>

	<div class="container">

	    <div class="row">
			<div class="col-md-8 col-md-offset-2">

	    		<div class="column main-column proposal-preview-column">
					<form action="{{ action('ProposeController@submit', $idea) }}" method="POST" onsubmit="return confirm('{{ trans('proposals.submit_confirmation') }}');">
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

							@foreach($design_tasks as $index => $design_task)

								<li class="proposal-item sortable" id="proposal-item-id-{{ $index }}" data-proposal-item-type="task" data-design-task-id="{{ $design_task->id }}" data-design-task-xmovement-task-type="{{ $design_task->xmovement_task_type }}" data-design-task-contribution-ids="{{ json_encode($design_task->contribution_ids) }}">

									<i class="fa fa-trash-o"></i>

									<a target="_blank" href="{{ $design_task->getLink() }}">
										<i class="fa fa-external-link"></i>
									</a>

									<i class="fa fa-pencil"></i>

									<span class="name-header">{{ $design_task->name }}</span>

									<?php echo $design_task->xmovement_task->renderProposalOutput($design_task); ?>

									<textarea class="proposal-item-details" name="name" placeholder="Justify this decision.." rows="8" cols="40"></textarea>

									<div class="clearfloat"></div>
								</li>

							@endforeach

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

	<script src="/js/propose/review.js"></script>

@endsection
