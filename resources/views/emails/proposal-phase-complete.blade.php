@extends('layouts.email')

@section('content')

	@include('emails/components/header', ['text' => trans('proposal_phase_complete_email.header', ['user_name' => $user->name])])

	@include('emails/components/wrapper-start')

		@include('emails/components/line', ['text' => trans('proposal_phase_complete_email.line_1', ['user_name' => $user->name, 'idea_name' => $idea->name])])

		@include('emails/components/line', ['text' => trans('proposal_phase_complete_email.line_2', ['supporter_count' => $idea->supporterCount()])])

		@include('emails/components/line', ['text' => trans('proposal_phase_complete_email.line_3')])

		@include('emails/proposal-tile', ['proposal' => $proposal])

		@include('emails/components/line', ['text' => trans('proposal_phase_complete_email.line_4', [])])

		@include('emails/components/line', ['text' => trans('proposal_phase_complete_email.line_5', [])])

		@include('emails/components/signature')

	@include('emails/components/wrapper-end')

@endsection
