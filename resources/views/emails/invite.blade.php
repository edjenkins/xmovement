@extends('layouts.email')

@section('content')

	@include('emails/components/header', ['text' => trans('invite_email.header', ['sender_name' => $sender->name])])

	@include('emails/components/wrapper-start')

		@include('emails/components/line', ['text' => trans('invite_email.line_1', ['receiver_name' => $receiver->name])])

		@include('emails/components/line', ['text' => trans('invite_email.line_2')])

		@include('emails/components/line', ['text' => trans('invite_email.line_3')])

		@include('emails/components/link', ['text' => trans('emails.view_idea_page'), 'url' => action('IdeaController@view', $idea)])

		@include('emails/components/signature')

	@include('emails/components/wrapper-end')

@endsection
