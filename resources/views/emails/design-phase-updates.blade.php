@extends('layouts.email')

@section('content')

	@include('emails/components/header', ['text' => trans('design_phase_updates_email.header')])

	@include('emails/components/wrapper-start')

		@include('emails/components/line', ['text' => trans('design_phase_updates_email.line_1', ['user_name' => $user->name])])

		@include('emails/components/line', ['text' => trans('design_phase_updates_email.line_2', ['idea_name' => $idea->name])])

		@include('emails/components/link', ['text' => trans('emails.view_dashboard_page'), 'url' => action('IdeaController@view', $idea)])

		@include('emails/components/signature')

	@include('emails/components/wrapper-end')

@endsection
