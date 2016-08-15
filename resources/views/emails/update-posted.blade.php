@extends('layouts.email')

@section('content')

	@include('emails/components/header', ['text' => trans('update_posted_email.header', ['sender_name' => $sender->name])])

	@include('emails/components/banner', ['image' => ResourceImage::getImage($idea->photo, 'banner')])

	@include('emails/components/wrapper-start')

		@include('emails/components/line', ['text' => trans('update_posted_email.line_1', ['sender_name' => $sender->name, 'idea_name' => $idea->name])])

		@include('emails/components/line', ['text' => trans('update_posted_email.line_2', ['sender_name' => $sender->name, 'text_name' => $text])])

		@include('emails/components/link', ['text' => trans('emails.view_idea_page'), 'url' => action('IdeaController@view', $idea)])

		@include('emails/components/signature')

	@include('emails/components/wrapper-end')

@endsection
