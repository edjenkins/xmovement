@extends('layouts.email')

@section('content')

	@include('emails/components/header', ['text' => trans('proposal_phase_open_email.header')])

	@include('emails/components/wrapper-start')

		@include('emails/components/line', ['text' => trans('proposal_phase_open_email.line_1', ['idea_name' => $idea->name])])

		@include('emails/components/line', ['text' => trans('proposal_phase_open_email.line_2', ['idea_name' => $idea->name])])

		@include('emails/components/link', ['text' => trans('emails.view_proposals_page'), 'url' => action('ProposeController@index', $idea)])

		@include('emails/components/line', ['text' => trans('proposal_phase_open_email.line_3', ['supporter_count' => $idea->supporterCount()])])

		@include('emails/components/line', ['text' => trans('proposal_phase_open_email.line_4')])

		@include('emails/components/line', ['text' => trans('proposal_phase_open_email.line_5')])

		@include('emails/components/line', ['text' => trans('proposal_phase_open_email.line_6')])

		@include('emails/components/line', ['text' => trans('proposal_phase_open_email.line_7', ['idea_name' => $idea->name, 'time' => $idea->proposalPhaseCloses()])])

		@include('emails/components/signature')

	@include('emails/components/wrapper-end')

@endsection
