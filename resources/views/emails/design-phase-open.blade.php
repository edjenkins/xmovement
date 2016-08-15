@extends('layouts.email')

@section('content')

	@include('emails/components/header', ['text' => trans('design_phase_open_email.header', ['idea_name' => $idea->name])])

	@include('emails/components/wrapper-start')

		@include('emails/components/line', ['text' => trans('design_phase_open_email.line_1')])

		@include('emails/components/link', ['text' => trans('emails.view_dashboard_page'), 'url' => action('IdeaController@view', $idea)])

		@include('emails/components/line', ['text' => trans('design_phase_open_email.line_2')])

		@include('emails/components/line', ['text' => trans('design_phase_open_email.line_3')])

		@include('emails/components/line', ['text' => trans('design_phase_open_email.line_4')])

		@include('emails/components/line', ['text' => trans('design_phase_open_email.line_5')])

		@include('emails/components/link', ['text' => trans('emails.live_for_x', ['idea_name' => $idea->name, 'time' => $idea->proposalPhaseCloses()]), 'url' => action('IdeaController@view', $idea)])

		@include('emails/components/signature')

	@include('emails/components/wrapper-end')

@endsection
