<li>

	<div class="requirement-space {{ isset($requirementFilled) ? 'filled' : 'not-filled' }} {{ Gate::allows('contribute', $design_task) ? 'unlocked' : 'locked' }}" data-requirement-id="{{ $requirement['id'] }}" data-requirement-filled-id="{{ isset($requirementFilled) ? $requirementFilled->id : '' }}">

		<div class="requirement-circle" style="{{ isset($requirementFilled) ? 'background-image: url(' . ResourceImage::getProfileImage($requirementFilled->user, "medium") . ')' : '' }}" data-user-background="{{ ResourceImage::getProfileImage(Auth::user(), 'small') }}">

			<i class="fa fa-check"></i>
			@can('contribute', $design_task)
				<i class="fa fa-plus"></i>
			@else
				<i class="fa fa-lock"></i>
			@endcan
			<i class="fa fa-times"></i>

			<div class="black-overlay"></div>

		</div>

		<div class="action-inputs">

			<button class="fill-button">{{ trans('xmovement_requirement.fill_requirement') }}</button>

			<button class="suggest-button" data-toggle="modal" data-target="#requirement-invite-modal">{{ trans('xmovement_requirement.invite') }}</button>

		</div>

		<div class="requirement-item">

			<h3>{{ $requirement['item'] }}</h3>
			<p>
				@can('contribute', $design_task)
					@if (isset($requirementFilled))
						@if ($requirementFilled->user->id == Auth::user()->id)
							<a class="withdraw-from-requirement" href="#">{{ trans('xmovement_requirement.you_filled_this_requirement') }}</a>
							<span class="not-filled-temp" style="display: none">{{ trans('xmovement_requirement.requirement_not_filled') }}</span>
						@else
							<a href="{{ action('UserController@profile', $requirementFilled->user) }}">{{ $requirementFilled->user->name }}</a>
							<span class="not-filled-temp" style="display: none">{{ trans('xmovement_requirement.requirement_not_filled') }}</span>
						@endif
					@else
						<a class="filled-temp withdraw-from-requirement" href="#">{{ trans('xmovement_requirement.you_filled_this_requirement') }}</a>
						<span class="not-filled-temp">{{ trans('xmovement_requirement.requirement_not_filled') }}</span>
					@endif
				@else
					@if (isset($requirementFilled))
						@if ($requirementFilled->user->id == Auth::user()->id)
							<span>{{ trans('xmovement_requirement.you_filled_this_requirement_locked') }}</span>
						@else
							<span>{{ $requirementFilled->user->name }}</span>
						@endif
					@else
						<span class="not-filled-temp">{{ trans('xmovement_requirement.requirement_not_filled') }}</span>
					@endif

				@endcan
			</p>

		</div>

	</div>

</li>
