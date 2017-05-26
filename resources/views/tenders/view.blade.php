@extends('layouts.app', ['bodyclasses' => 'grey'])

@section('content')

	<div ng-controller="TenderController" ng-cloak>

		<div class="page-header">

	        <h2 class="main-title">{{ trans('tenders.tender') }}</h2>
			<h5 class="sub-title"><a target="_self" href="{{ action('IdeaController@view', $tender->idea) }}">{{ $tender->idea->name }}</a></h5>

		</div>

	    <div class="white-controls-row">

			<div class="container">

				<div class="view-controls-container">

					<ul class="module-controls pull-left">

						<li class="module-control">

							<a target="_self" href="{{ action('TenderController@index', $tender->idea) }}">

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
								<div class="avatar-wrapper">
									<div class="avatar" style="background-image: url('{{ ResourceImage::getImage($tender->team->avatar, 'small') }}')"></div>
								</div>
							</div>

							<h3>
								{{ str_limit($tender->team->name, $limit = 80, $end = '...') }}
							</h3>

							<p>
								{{ $tender->team->bio }}
							</p>

							<p>
								Contact - <a target="_self" href="mailto:{{ $tender->team->email }}">{{ $tender->team->email }}</a>
							</p>

						</div>

						<div class="tender-team" ng-init="adding_team_member = false">

							<div class="team-label">
								Team Members
							</div>

							<ul class="team-members">

								<li class="team-member" ng-repeat="user in tender.team.users" ng-click="removeUserFromTeam(user)">
									<div class="tender-avatar">
										<a target="_blank" class="avatar-wrapper" href="/profile/<% user.id %>">
											<div class="avatar" style="background-image: url('<% getProfileImage(user, 'thumb') %>')"></div>
										</a>
										@can('remove_user', $tender->team)
											<div class="tender-avatar-overlay">
												<i class="fa fa-trash"></i>
											</div>
										@endcan
									</div>
								</li>

								@can('add_user', $tender->team)

									<li class="add-team-member team-member" ng-click="adding_team_member = !adding_team_member" onClick="$('.add-team-member-search').focus();">
										<i class="fa fa-plus"></i>
									</li>

								@endcan

								<div class="clearfloat"></div>

							</ul>

							@can('edit', $tender)

								<div class="add-team-member-form-container" ng-show="adding_team_member" ng-class="{'has-results':((user_search_results.length > 0) || no_search_results)}">

									<form class="auth-form add-team-member-form" role="form" method="POST" action="{{ action('TenderController@submit') }}">
								        {!! csrf_field() !!}

								        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
								            <label class="control-label">{{ trans('tender.name') }}</label>

								            <input type="text" class="form-control add-team-member-search" name="name" ng-init="user_search_term = ''" ng-model="user_search_term" placeholder="{{ trans('tender.name_placeholder') }}">

											<div class="searching-users" ng-init="searching_users = false" ng-show="searching_users">
												<i class="fa fa-spin fa-refresh"></i>
											</div>
								        </div>

									</form>

									<ul class="user-results" ng-show="(user_search_results.length > 0) || no_search_results">
										<li ng-show="no_search_results">
											<p>
												No Users Found
											</p>
										</li>
										<li class="user-search-result" ng-repeat="user in user_search_results" ng-click="addUserToTeam(user)">
											<div class="tender-avatar">
												<div class="avatar-wrapper">
													<div class="avatar" style="background-image: url('<% getProfileImage(user, 'thumb') %>')"></div>
													<div class="add-overlay">
														<i class="fa fa-plus"></i>
													</div>
												</div>
											</div>
											<p>
												<% user.name %>
											</p>
										</li>
									</ul>

								</div>

							@endcan

						</div>

					</div>

					<div class="timeline-section">

						<div class="tender-preview">

							<a target="_blank" class="pdf-preview" href="{{ ResourceImage::getFile($tender->document) }}">
								<i class="fa fa-file-pdf-o"></i>
								<h5>View PDF</h5>
							</a>

							<h5>
								{{ trans('tenders.tender_document') }}
							</h5>

							<p>
								{{ $tender->summary }}
							</p>

						</div>

					</div>

					<div class="timeline-section" ng-show="tender.answers.length > 0">

						<div class="tender-questions">

							<ul>

								<li class="tender-question" ng-repeat="answer in tender.answers">

									<h5>
										<% answer.question.question %>
									</h5>

									<p>
										<% answer.answer %>
									</p>

									<a ng-click="openQuestionModal(answer)">
										<i class="fa fa-fw fa-comment"></i>
										View Comments
									</a>

								</li>

							</ul>

						</div>

					</div>

					<div class="timeline-section" ng-repeat="update in tender.updates">

						<div class="tender-update update" id="update-<% update.id %>">

							<div class="update-label">
								<% update.created_at | amDateFormat:'Do MMMM \'YY' %>
							</div>

							<p ng-bind-html="update.text | trust"></p>

						</div>

					</div>

					@can('post_update', $tender)

						<div class="timeline-section">

							<div class="updates-section">

								<div class="post-update-container">

									<div class="creator-avatar" style="background-image:url('{{ ResourceImage::getProfileImage(Auth::user(), 'medium') }}')"></div>

									<div class="update-composer-wrapper">

										<textarea class="expanding" rows="1" ng-model="update" name="text" placeholder="{{ trans('tender.update_text_placeholder') }}"></textarea>

										<button type="button" class="post-update-button" ng-click="postUpdate()">
											<span class="idle-state">
												{{ trans('tender.update_button_idle') }}
											</span>
											<span class="posting-state">
												{{ trans('tender.update_button_posting') }}
											</span>
										</button>

										<ul class="error-list" id="update-errors"></ul>

									</div>

								</div>

							</div>

						</div>

					@endcan

	    		</div>

				<div class="comments-section">

					@include('discussion', ['target_id' => $tender->id, 'target_type' => 'Tender', 'idea_id' => $tender->idea->id])

				</div>

	    	</div>

	    </div>

		@include('modals/tenders/question')

	</div>

	<script type="text/javascript">
		var tender = {!! json_encode($tender) !!};
	</script>

	<script src="{{ URL::asset('js/angular-dependencies.js') }}"></script>
	<script src="{{ URL::asset('js/angular.js') }}"></script>

@endsection
