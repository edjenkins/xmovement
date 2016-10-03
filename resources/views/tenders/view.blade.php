@extends('layouts.app')

@section('content')

	@include('grey-background')

	<div class="page-header">

        <h2 class="main-title">{{ trans('tenders.tender') }}</h2>
		<h5 class="sub-title"><a href="{{ action('IdeaController@view', $tender->idea) }}">{{ $tender->idea->name }}</a></h5>

	</div>

    <div class="white-controls-row">

		<div class="container">

			<div class="view-controls-container">

				<ul class="module-controls pull-left">

					<li class="module-control">

						<a href="{{ action('TenderController@index', $tender->idea) }}">

							<i class="fa fa-chevron-left"></i>

							{{ trans('tenders.back_to_tenders') }}

						</a>

					</li>

				</ul>

				@can('destroy', $tender)

					<ul class="module-controls pull-right">

						<li class="module-control">

							<form action="{{ action('TenderController@destroy', $tender) }}" method="POST" onsubmit="return confirm('Do you really want to delete this?');">
								{!! csrf_field() !!}
								{!! method_field('DELETE') !!}

								<button type="submit">
									<i class="fa fa-trash"></i>
									{{ trans('tenders.delete_tender') }}
								</button>
							</form>

						</li>

					</ul>

				@endcan

				<div class="clearfloat"></div>

			</div>

	    </div>

	</div>

	<div class="container tender-container">

		<div class="col-md-10 col-md-offset-1">

    		<div class="column main-column timeline-column">

				<div class="timeline-section">

					<div class="tender-author">

						<div class="tender-avatar">
							<a href="{{ action('UserController@profile', $tender->user) }}" class="avatar-wrapper">
								<div class="avatar" style="background-image: url('{{ ResourceImage::getImage($tender->company_logo, 'large') }}')"></div>
							</a>
						</div>

						<h3>
							{{ str_limit($tender->company_name, $limit = 80, $end = '...') }}
						</h3>

						<p>
							{{ $tender->summary }}
						</p>

						<p>
							Contact - <a href="mailto:{{ $tender->contact_email_address }}">{{ $tender->contact_email_address }}</a>
						</p>

					</div>

				</div>

				<div class="timeline-section">

					<div class="tender-preview">

						<div class="pdf-preview">
							<i class="fa fa-file-pdf-o"></i>
							<h5>View PDF</h5>
						</div>

						<p>
							{{ trans('tenders.added_by_x_x', ['name' => $tender->user->name, 'time' => $tender->created_at->diffForHumans()]) }}
						</p>

						<p>
							Our tender meets the expectations set in the design process. We aim to deliver a slick app which is intuituve for people of all ages. Read our full tender document on the left to see how we plan to meet the requirements for this application and deliver it to a national audience in a professional, reliable manner.
						</p>

					</div>

				</div>

				<div class="timeline-section">

					<div class="tender-questions">

						<ul>
							<li class="tender-question">
								<h5>
									What technologies will you be using?
								</h5>

								<p>
									We have a lot of experience using AngularJS so we will be using this modern web technology as the base for our application. We will be using MongoDB for storing data and Redis for storing sessions.
								</p>
							</li>
							<li class="tender-question">
								<h5>
									How many people will be working on the project?
								</h5>

								<p>
									Our team consits of 8 people, we will have a minimum of 3 people working on this at any one time. We work in an open office so our team can reach out to other members for specific expertise when required.
								</p>
							</li>
						</ul>

					</div>

				</div>

				<div class="timeline-section">

					<div class="tender-update">

						<div class="update-label">
							23 September '17
						</div>

						<h5>
							New wireframes
						</h5>

						<p>
							Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
						</p>

					</div>

				</div>



    		</div>

			<div class="comments-section">

				@include('discussion')

			</div>

    	</div>

    </div>

@endsection
