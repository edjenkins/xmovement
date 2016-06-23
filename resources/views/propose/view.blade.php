@extends('layouts.app')

@section('content')

	@include('grey-background')

	<div class="page-header">

        <h2 class="main-title">Proposal</h2>
		<h5 class="sub-title"><a href="{{ action('IdeaController@view', $proposal->idea) }}">{{ $proposal->idea->name }}</a></h5>

	</div>

    <div class="white-controls-row">

		<div class="container">

			<div class="view-controls-container">

				<ul class="module-controls pull-left">

					<li class="module-control">

						<a href="{{ action('ProposeController@index', $proposal->idea) }}">

							<i class="fa fa-chevron-left"></i>

							Back to Proposals

						</a>

					</li>

				</ul>

				@can('destroy', $proposal)

					<ul class="module-controls pull-right">

						<li class="module-control">

							<form action="{{ action('ProposeController@destroy', $proposal) }}" method="POST" onsubmit="return confirm('Do you really want to delete this?');">
								{!! csrf_field() !!}
								{!! method_field('DELETE') !!}

								<button type="submit">
									<i class="fa fa-trash"></i>
									Delete Proposal
								</button>
							</form>

						</li>

					</ul>

				@endcan

				<div class="clearfloat"></div>

			</div>

	    </div>

	</div>

	<div class="container">

		<div class="col-md-8 col-md-offset-2">

    		<div class="column main-column proposal-preview-column">

				<ul class="proposal-preview">

					<li class="proposal-item user-header">
						<div class="avatar-wrapper">
							<div class="avatar" style="background-image: url('/uploads/images/small/{{ $proposal->user->avatar }}/{{ urlencode($proposal->user->name) }}')"></div>
						</div>
						<br>
						<h3>{{ $proposal->description }}</h3>
						<p>
							Added {{ $proposal->created_at->diffForHumans() }}
						</p>
					</li>

					@foreach($proposal_items as $index => $proposal_item)

						@if ($proposal_item->type == 'task')

							<li class="proposal-item">

								<a href="{{ $proposal_item->design_task->getLink() }}" target="_blank">
									<i class="fa fa-external-link"></i>
								</a>

								<span class="name-header">{{ $proposal_item->design_task->name }}</span>

								<?php echo $proposal_item->design_task->xmovement_task->renderProposalOutput($proposal_item->design_task); ?>

								<div class="clearfloat"></div>
							</li>

						@endif

						@if ($proposal_item->type == 'text')

							<li class="proposal-item">

								<p>
									{{ $proposal_item->text }}
								</p>

								<div class="clearfloat"></div>
							</li>

						@endif

					@endforeach

					<li class="proposal-footer">

						<div class="vote-container proposal-vote-container {{ ($proposal->voteCount() == 0) ? '' : (($proposal->voteCount() > 0) ? 'positive-vote' : 'negative-vote') }}">
							<div class="vote-controls">
								<div class="vote-button vote-up {{ ($proposal->userVote() > 0) ? 'voted' : '' }}" data-vote-direction="up" data-votable-type="proposal" data-votable-id="{{ $proposal['id'] }}">
									<i class="fa fa-2x fa-angle-up"></i>
								</div>
								<div class="vote-count">
									{{ $proposal->voteCount() }}
								</div>
								<div class="vote-button vote-down {{ ($proposal->userVote() < 0) ? 'voted' : '' }}" data-vote-direction="down" data-votable-type="proposal" data-votable-id="{{ $proposal['id'] }}">
									<i class="fa fa-2x fa-angle-down"></i>
								</div>
								<div class="clearfloat"></div>
							</div>
						</div>

					</div>

				</ul>

    		</div>

    	</div>

    </div>

	<script src="/js/propose/vote.js"></script>

@endsection
