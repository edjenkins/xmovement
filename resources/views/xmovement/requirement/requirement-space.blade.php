<li>

	<div class="requirement-space {{ isset($requirementFilled) ? 'filled' : 'not-filled' }}" data-requirement-id="{{ $requirement['id'] }}" data-requirement-filled-id="{{ isset($requirementFilled) ? $requirementFilled->id : '' }}">

		<div class="requirement-circle" style="{{ isset($requirementFilled) ? 'background-image: url(' . ResourceImage::getProfileImage($user, "medium") . ')' : '' }}" data-user-background="{{ ResourceImage::getProfileImage(Auth::user(), 'small') }}">

			<i class="fa fa-check"></i>
			<i class="fa fa-plus"></i>
			<i class="fa fa-times"></i>

			<div class="black-overlay"></div>

		</div>

		<div class="action-inputs">

			<button class="fill-button">Fill this requirement</button>

			<button class="suggest-button" data-toggle="modal" data-target="#requirement-invite-modal">Invite someone you know</button>

		</div>

		<div class="requirement-item">

			<h3>{{ $requirement['item'] }}</h3>
			<p>
				@if (isset($requirementFilled))
					@if ($requirementFilled->user->id == Auth::user()->id)
						<a class="withdraw-from-requirement" href="#">You have filled this requirement (undo)</a>
						<span class="not-filled-temp" style="display: none">Requirement not filled</span>
					@else
						<a href="{{ action('UserController@profile', $requirementFilled->user) }}">{{ $requirementFilled->user->name }}</a>
						<span class="not-filled-temp" style="display: none">Requirement not filled</span>
					@endif
				@else
					<a class="filled-temp withdraw-from-requirement" href="#">You have filled this requirement (undo)</a>
					<span class="not-filled-temp">Requirement not filled</span>
				@endif
			</p>

		</div>

	</div>

</li>
