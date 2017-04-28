@extends('layouts.email')

@section('content')

	@include('emails/components/header', ['text' => trans('contact_email.header', ['name' => $name])])

	@include('emails/components/wrapper-start')

		@include('emails/components/line', ['text' => trans('contact_email.line_1', ['text' => $text, 'name' => $name])])

		@include('emails/components/line', ['text' => trans('contact_email.line_2', ['email' => $email])])

		@include('emails/components/signature')

	@include('emails/components/wrapper-end')

@endsection
