@extends('layouts.email')

@section('content')

	@include('emails/components/header', ['text' => trans('support_email.header')])

	@include('emails/components/banner', ['image' => ResourceImage::getImage($idea->photo, 'banner')])

	@include('emails/components/wrapper-start')

		@include('emails/components/line', ['text' => trans('support_email.line_1', ['idea_name' => $idea->name])])

		@include('emails/components/line', ['text' => trans('support_email.line_2')])

		@include('emails/components/link', ['text' => trans('emails.view_about_page'), 'url' => action('PageController@about')])

		@include('emails/components/line', ['text' => trans('support_email.line_3')])

		@include('emails/components/line', ['text' => trans('support_email.line_4', ['idea_name' => $idea->name])])

		@include('emails/components/link', ['text' => trans('emails.view_idea_page'), 'url' => action('IdeaController@view', $idea)])

		@include('emails/components/signature')

	@include('emails/components/wrapper-end')

@endsection
