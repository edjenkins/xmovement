@extends('layouts.app', ['bodyclasses' => 'grey'])

@section('content')

	<div ng-controller="AddTenderController" ng-cloak>

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

				<form class="auth-form team-form" role="form" method="POST" action="{{ action('TeamController@submit') }}">
			        {!! csrf_field() !!}

					<h3>{{ trans('team.team') }}</h3>

			        <ul class="team-selector" ng-class="{'team-selected':(selected_team || adding_team)}">
			        	<li ng-repeat="team in teams" ng-click="selectTeam(team)" ng-class="{'selected':(selected_team.id == team.id)}">
							<% team.name %>
						</li>
						<li ng-click="selectTeam(null)" ng-class="{'selected':adding_team}">
							Create Team
						</li>
			        </ul>

					<div class="add-team-form" ng-show="adding_team">

				        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
				            <label class="control-label">{{ trans('team.name') }}</label>

				            <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="{{ trans('team.name_placeholder') }}">

				            @if ($errors->has('name'))
				                <span class="help-block">
				                    <strong>{{ $errors->first('name') }}</strong>
				                </span>
				            @endif
				        </div>

				        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
				            <label class="control-label">{{ trans('team.email') }}</label>

				            <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="{{ trans('team.email_placeholder') }}">

				            @if ($errors->has('email'))
				                <span class="help-block">
				                    <strong>{{ $errors->first('email') }}</strong>
				                </span>
				            @endif
				        </div>

				        <div class="form-group{{ $errors->has('bio') ? ' has-error' : '' }}">
				            <label class="control-label">{{ trans('team.bio') }}</label>

				            <textarea class="expanding" name="bio" rows="3" placeholder="{{ trans('team.bio_placeholder') }}">{{ old('bio') }}</textarea>

				            @if ($errors->has('bio'))
				                <span class="help-block">
				                    <strong>{{ $errors->first('bio') }}</strong>
				                </span>
				            @endif
				        </div>

				        <div class="form-group{{ $errors->has('avatar') ? ' has-error' : '' }}">
				            <label class="control-label">{{ trans('team.avatar') }}</label>

							@include('dropzone', ['type' => 'image', 'cc' => false, 'input_id' => 'avatar', 'value' => old('avatar'), 'dropzone_id' => 1])

				            @if ($errors->has('avatar'))
				                <span class="help-block">
				                    <strong>{{ $errors->first('avatar') }}</strong>
				                </span>
				            @endif
				        </div>

				        <div class="form-group">
				            <button type="submit" class="btn btn-primary pull-right">
				                {{ trans('team.create_team') }}
				            </button>
							<div class="clearfloat">

							</div>
				        </div>

					</div>

				</form>

				<form class="auth-form tender-form" role="form" method="POST" action="{{ action('TenderController@submit') }}" ng-show="selected_team">
			        {!! csrf_field() !!}

					<input type="hidden" name="idea_id" value="{{ $idea->id }}">

					<input type="hidden" name="team_id" ng-value="selected_team.id">

					<h3>Tender</h3>

					<div class="form-group{{ $errors->has('document') ? ' has-error' : '' }}">
						<label class="control-label">{{ trans('tender.document') }}</label>

						@include('dropzone', ['type' => 'file', 'input_id' => 'document', 'value' => old('document'), 'dropzone_id' => 2])

						@if ($errors->has('document'))
							<span class="help-block">
								<strong>{{ $errors->first('document') }}</strong>
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

					@foreach ($tender_questions as $index => $question)

						<div class="form-group">
							<label class="control-label">
								@if (!$question->public)
									<i class="fa fa-lock fa-fw"></i>
								@endif
								{{ $question->question }}
							</label>

							<textarea class="expanding" name="answers[{{ $question->id }}]" rows="1" placeholder="{{ trans('tender.write_your_answer_here') }}">{{ old('answers[' . $question->id . ']') }}</textarea>

						</div>

					@endforeach

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

	</div>

	<script src="{{ URL::asset('js/angular-dependencies.js') }}"></script>
	<script src="{{ URL::asset('js/angular.js') }}"></script>

@endsection
