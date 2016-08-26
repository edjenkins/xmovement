@extends('layouts.email')

@section('content')

	@include('emails/components/header', ['text' => trans('create_idea_email.header', ['idea_name' => $idea->name])])

	@include('emails/components/wrapper-start')
	
		@include('emails/components/line', ['text' => trans('create_idea_email.line_1')])

		@include('emails/components/subheader', ['text' => trans('create_idea_email.line_2')])

		@include('emails/components/line', ['text' => trans('create_idea_email.line_3')])

		@include('emails/components/subheader', ['text' => trans('create_idea_email.line_4')])

		@include('emails/components/line', ['text' => trans('create_idea_email.line_5')])

		@include('emails/components/subheader', ['text' => trans('create_idea_email.line_6')])

		@include('emails/components/line', ['text' => trans('create_idea_email.line_7')])

		@include('emails/components/line', ['text' => trans('create_idea_email.line_8')])

		@include('emails/components/link', ['text' => trans('emails.view_about_page'), 'url' => action('PageController@about')])

		@include('emails/components/signature')

	@include('emails/components/wrapper-end')

@endsection
