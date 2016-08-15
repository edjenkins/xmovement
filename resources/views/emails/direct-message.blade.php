@extends('layouts.email')

@section('content')

	@include('emails/components/header', ['text' => trans('direct_message_email.header', ['sender_name' => $sender->name])])

	@include('emails/components/wrapper-start')

		@include('emails/components/line', ['text' => trans('direct_message_email.line_1', ['text' => $direct_message->text, 'sender_name' => $sender->name])])

		@include('emails/components/signature')

	@include('emails/components/wrapper-end')

@endsection
