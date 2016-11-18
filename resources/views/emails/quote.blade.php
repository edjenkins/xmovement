@extends('layouts.email')

@section('content')

	@include('emails/components/header', ['text' => trans('quote_email.header')])

	@include('emails/components/wrapper-start')

		@include('emails/components/line', ['text' => trans('quote_email.line_1', ['quote' => $quote])])

	@include('emails/components/wrapper-end')

@endsection
