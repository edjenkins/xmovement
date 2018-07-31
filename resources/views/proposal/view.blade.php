@extends('layouts.app')

@section('content')

	@include('grey-background')

	<div class="page-header">

        <h2 class="main-title">{{ trans('proposals.proposal') }}</h2>
		<h5 class="sub-title"><a target="_self" href="{{ action('IdeaController@view', $proposal->idea) }}">{{ $proposal->idea->name }}</a></h5>

	</div>

    <div class="white-controls-row">

		<div class="container">

			<div class="view-controls-container">

				<ul class="module-controls pull-left">

					<li class="module-control">

						<a target="_self" href="{{ action('ProposalController@index', $proposal->idea) }}">

							<i class="fa fa-chevron-left"></i>

							{{ trans('proposals.back_to_proposals') }}

						</a>

					</li>

				</ul>

				@can('destroy', $proposal)

					<ul class="module-controls pull-right">

						<li class="module-control">

							<form action="{{ action('ProposalController@destroy', $proposal) }}" method="POST" onsubmit="return confirm('Do you really want to delete this?');">
								{!! csrf_field() !!}
								{!! method_field('DELETE') !!}

								<button type="submit">
									<i class="fa fa-trash"></i>
									{{ trans('proposals.delete_proposal') }}
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
						<a target="_self" href="{{ action('UserController@profile', $proposal->user) }}" class="avatar-wrapper">
							<div class="avatar" style="background-image: url('{{ ResourceImage::getProfileImage($proposal->user, 'small') }}')"></div>
						</a>
						<br>
						<h3>{{ $proposal->description }}</h3>
						<p>
							{{ trans('proposals.added_by_x_x', ['name' => $proposal->user->name, 'time' => $proposal->created_at->diffForHumans()]) }}
						</p>
					</li>

					@foreach($proposal_items as $index => $proposal_item)

						@if ($proposal_item->type == 'task')

							<li class="proposal-item">

								<a target="_blank" href="{{ $proposal_item->design_task->getLink() }}">
									<i class="fa fa-external-link"></i>
								</a>

								<span class="name-header">{{ $proposal_item->design_task->name }}</span>

								<?php echo $proposal_item->design_task->xmovement_task->renderProposalOutput($proposal_item->design_task); ?>

								@if(isset($proposal_item->proposal_item_details))
									@if($proposal_item->proposal_item_details != "")
										<p class="proposal-item-details">
											{{ $proposal_item->proposal_item_details }}
										</p>
									@endif
								@endif

								<div class="clearfloat"></div>
							</li>

						@endif

						@if ($proposal_item->type == 'text')

							<li class="proposal-item">

								<p>
									{!! nl2br($proposal_item->text) !!}
								</p>

								<div class="clearfloat"></div>
							</li>

						@endif

						@if ($proposal_item->type == 'file')

							@unless ($proposal_item->url === '')

								<li class="proposal-item">

									<a href="{{ ResourceImage::getFile($proposal_item->url) }}" target="_blank" class="btn btn-primary">
										<i class="fa fa-file-pdf-o fa-fw"></i>
										{{ trans('proposals.view_proopsal_document') }}
									</a>

									<div class="clearfloat"></div>
								</li>

							@endunless

						@endif

					@endforeach

					<li class="proposal-footer">

						<div class="proposal-vote-container {{ ($proposal->voteCount() == 0) ? '' : (($proposal->voteCount() > 0) ? 'positive-vote' : 'negative-vote') }}">
							<div class="vote-controls">
								@can('vote_on_proposals', $proposal)
									<div class="vote-button vote-up {{ ($proposal->userVote() > 0) ? 'voted' : '' }}" data-vote-direction="up" data-votable-type="proposal" data-votable-id="{{ $proposal['id'] }}">
										<i class="fa fa-lg fa-thumbs-up"></i>
									</div>
								@endcan
								<div class="vote-count">
									{{ $proposal->voteCount() }}
								</div>
								@can('vote_on_proposals', $proposal)
									<div class="vote-button vote-down {{ ($proposal->userVote() < 0) ? 'voted' : '' }}" data-vote-direction="down" data-votable-type="proposal" data-votable-id="{{ $proposal['id'] }}">
										<i class="fa fa-lg fa-thumbs-down"></i>
									</div>
								@endcan
								<div class="clearfloat"></div>
							</div>
						</div>

					</li>

				</ul>

				<div class="clearfloat"></div>

				<div class="comments-section with-border">

					@include('discussion', ['target_id' => $proposal->id, 'target_type' => 'Proposal', 'idea_id' => $proposal->idea->id])

				</div>

    		</div>

    	</div>

    </div>

	<script src="/js/proposal/vote.js"></script>

@endsection
