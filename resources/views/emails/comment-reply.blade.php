@extends('layouts.email')

@section('content')

	@include('emails/components/header', ['text' => trans('comment_reply_email.header', ['sender_name' => $sender->name])])

	@include('emails/components/wrapper-start')

		@include('emails/components/line', ['text' => trans('comment_reply_email.line_1', ['text' => $comment->text, 'receiver_name' => $receiver->name])])

		@include('emails/components/line', ['text' => trans('comment_reply_email.line_2', ['text' => $comment->text, 'sender_name' => $sender->name])])

		@include('emails/components/signature')

	@include('emails/components/wrapper-end')

@endsection
