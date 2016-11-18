@extends('layouts.email')

@section('content')

	@include('emails/components/header', ['text' => trans('proposal_phase_failed_email.header')])

	@include('emails/components/wrapper-start')

		@include('emails/components/line', ['text' => trans('proposal_phase_failed_email.line_1', ['user_name' => $user->name, 'idea_name' => $idea->name])])

		@include('emails/components/line', ['text' => trans('proposal_phase_failed_email.line_2', ['idea_name' => $idea->name])])

		@include('emails/components/line', ['text' => trans('proposal_phase_failed_email.line_3', ['supporter_count' => $idea->supporterCount()])])

		@include('emails/components/line', ['text' => trans('proposal_phase_failed_email.line_4')])

		@include('emails/components/signature')

	@include('emails/components/wrapper-end')

@endsection
