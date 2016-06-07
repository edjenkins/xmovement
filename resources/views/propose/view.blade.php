@extends('layouts.app')

@section('content')

	<div class="page-header colorful">

        <h2 class="main-title">Proposal</h2>

	</div>

	<div class="container">

	    <div class="row">

			<div class="col-md-12">

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

			<div class="col-md-8 col-md-offset-2">

	    		<div class="column main-column proposal-preview-column">

					<ul class="proposal-preview">

						<li class="proposal-item user-header">
							<div class="avatar-wrapper">
								<img class="avatar" style="background-image: url('/uploads/images/small/{{ $proposal->user->avatar }}')">
							</div>
							<br>
							<h4>{{ $proposal->description }}</h4>
						</li>

						@foreach($proposal_items as $index => $proposal_item)

							@if ($proposal_item->type == 'task')

								<li class="proposal-item">
									<span class="name-header">{{ $proposal_item->design_task->name }}</span>

									@foreach($proposal_item->design_task->contributions as $contribution)

										<?php echo $contribution->renderTile($contribution); ?>

									@endforeach

									<div class="clearfloat"></div>
								</li>

							@endif

							@if ($proposal_item->type == 'text')

								<li class="proposal-item">
									<span class="name-header">Proposal description</span>

									<p>
										{{ $proposal_item->text }}
									</p>

									<div class="clearfloat"></div>
								</li>

							@endif

						@endforeach

						<li class="proposal-footer">
							<ul class="proposal-vote-controls">
								<li>
									<i class="fa fa-angle-down"></i>
								</li>
								<li>
									<i class="fa fa-angle-up"></i>
								</li>
							</ul>
						</li>

					</ul>

	    		</div>

	    	</div>
	    </div>
	</div>

@endsection
