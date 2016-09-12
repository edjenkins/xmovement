<div class="modal fade" id="supporters-modal" tabindex="-1" role="dialog">

	<div class="modal-dialog" role="document">

		<div class="modal-content">

			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

				<h4 class="modal-title">{{ trans('idea.supporters') }}</h4>

			</div>

			<div class="modal-body">

				<p class="text-muted">
					{{ trans('idea.supporters_modal_label') }}
				</p>

				<ul class="modal-list supporters-list">

					@foreach($idea->supporters as $supporter)
						<li class="supporter-list-item">
							<a href="{{ action('UserController@profile', $supporter) }}" target="_blank">
								<div class="user-avatar" style="background-image:url('{{ ResourceImage::getProfileImage($supporter, 'medium') }}')"></div>
								<div class="user-name">
									{{ $supporter->name }}
								</div>
								<i class="user-profile-arrow fa fa-fw fa-angle-right"></i>
							</a>
						</li>
					@endforeach

				</ul>

			</div>

			<div class="modal-footer">

				<button type="button" class="btn btn-primary" data-dismiss="modal">{{ trans('common.done') }}</button>

			</div>

		</div>

	</div>

</div>
