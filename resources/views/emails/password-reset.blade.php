@extends('layouts.email')

@section('content')

	@include('emails/components/header', ['text' => trans('password_reset_email.header')])

	@include('emails/components/wrapper-start')

		@include('emails/components/line', ['text' => trans('password_reset_email.line_1', ['user_name' => $user->name])])

		@include('emails/components/line', ['text' => trans('password_reset_email.line_2')])

		@include('emails/components/link', ['text' => trans('emails.reset_password'), 'url' => url('password/reset', $token).'?email='.urlencode($user->getEmailForPasswordReset())])

		@include('emails/components/signature')

	@include('emails/components/wrapper-end')

@endsection
