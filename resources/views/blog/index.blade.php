@extends('layouts.app', ['bodyclasses' => 'medium-grey'])

@section('content')

	<div class="page-header">

		<h2 class="main-title">Our Blog</h2>

	</div>

	<div class="container blog-container">

		<div class="row">

			<div class="col-md-12">

				@foreach($blog_posts as $indexKey => $blog_post)

					<div class="{{ $indexKey == 0 ? 'col-md-12' : 'col-md-6' }}">

						<br>

						<div class="floating-page-tile blog-post-tile">
							<h3>
								{{ $blog_post->title }}
							</h3>
							<h5 class="text-muted">
								Posted {{ $blog_post->created_at->diffForHumans() }}
							</h5>

							{!! $blog_post->content !!}

							<div class="author-container">

								<div class="author-avatar" style="background-image:url('{{ ResourceImage::getProfileImage($blog_post->user, 'medium') }}')"></div>

								<div class="author-details muted-text">
									<div class="author-header">
										{{ trans('common.author') }}
									</div>
									<div class="author-subheader">
										<a href="{{ action('UserController@profile', $blog_post->user_id) }}">
											{{ $blog_post->user->name }}
										</a>
									</div>
								</div>

							</div>

						</div>

					</div>

				@endforeach

			</div>

		</div>

	</div>
@endsection
