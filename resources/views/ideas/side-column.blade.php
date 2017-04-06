<div class="row">
	<div class="col-md-12 col-sm-6">

		<div class="creator-tile" onClick="document.location = '{{ action('UserController@profile', $idea->user_id) }}';">
			<div class="creator-avatar" style="background-image:url('{{ ResourceImage::getProfileImage($idea->user, 'medium') }}')"></div>
			<h4>{{ $idea->user->name }}</h4>
			<h5 class="subtitle">{{ trans('idea.creator') }}</h5>
		</div>

	</div>

	<div class="col-md-12 col-sm-6">

		<div class="stats-tile supporters-tile">
			<div class="supporters-tile-inner" data-toggle="modal" data-target="#supporters-modal">
				<h3 class="supporter-count">
					{{ $idea->supporterCount() }}
				</h3>
				<h5 class="supporter-subtitle">
					{{ trans_choice('idea.supporters', $idea->supporterCount()) }}
				</h5>
				<div class="stats-tile-footer supporters-tile-footer{{ $supported ? ' visible' : '' }}">{{ trans('common.you_supported_idea') }}</div>
			</div>

			<ul class="sidebar-social-links">
				<li class="share-fb"><i class="fa fa-facebook"></i></li>
				<li class="share-twitter"><i class="fa fa-twitter"></i></li>
				<li class="share-googleplus"><i class="fa fa-google-plus"></i></li>
				<li class="share-email"><i class="fa fa-envelope"></i></li>
				<div class="clearfloat"></div>
			</ul>
		</div>

		@include('action-button')

		@if ($idea->design_state == 'closed')

			@if ((DynamicConfig::fetchConfig('MIN_SUPPORTER_COUNT', 0) - $idea->supporterCount()) > 0)

				<div class="info-tile">
					<div class="info-tile-content">
						<p>
							<i class="fa fa-info"></i>
							<p>{{ (DynamicConfig::fetchConfig('MIN_SUPPORTER_COUNT', 0) - $idea->supporterCount()) }}</p>
							{{ trans('idea.x_supporters_needed_to_progress', ['supporter_count' => (DynamicConfig::fetchConfig('MIN_SUPPORTER_COUNT', 0) - $idea->supporterCount())]) }}
						</p>
					</div>
				</div>

			@else

				<div class="info-tile">
					<div class="info-tile-content">
						<p>
							<i class="fa fa-info"></i>
							{{ trans('idea.design_area_opens', ['time' => $idea->designPhaseOpens()]) }}
						</p>
					</div>
				</div>

			@endif

		@elseif ($idea->proposal_state == 'closed')

			<div class="info-tile">
				<div class="info-tile-content">
					<p>
						<i class="fa fa-info"></i>
						{{ trans('idea.proposal_area_opens', ['time' => $idea->proposalPhaseOpens()]) }}
					</p>
				</div>
			</div>

		@endif

	</div>
	<div class="clearfix">

	</div>
</div>
