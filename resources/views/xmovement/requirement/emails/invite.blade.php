@extends('layouts.email')

@section('content')

	@include('emails/components/header', ['text' => trans('xmovement_invite_email.header', ['idea_name' => $idea->name])])

	@include('emails/components/wrapper-start')

		@include('emails/components/line', ['text' => trans('xmovement_invite_email.line_1', ['receiver_name' => $name])])

		@include('emails/components/subheader', ['text' => trans('xmovement_invite_email.line_2', ['sender_name' => $user->name])])

		@include('emails/components/link', ['text' => trans('emails.view_requirement'), 'url' => $link])

		@include('emails/components/line', ['text' => trans('xmovement_invite_email.line_3', ['sender_name' => $user->name])])

		@include('emails/components/subheader', ['text' => trans('xmovement_invite_email.line_4', ['text' => $personal_message])])

		@include('emails/components/signature')

	@include('emails/components/wrapper-end')

@endsection
