<li>

	<div class="requirement-space {{ isset($requirementFilled) ? 'filled' : 'not-filled' }}">
		
		<div class="requirement-circle" style="{{ isset($requirementFilled) ? 'background-image: url("' . $requirementFilled->user->avatar . '")' : '' }}" data-user-background="{{ Auth::user()->avatar }}">

			<i class="fa fa-check"></i>
			<i class="fa fa-plus"></i>
			<i class="fa fa-times"></i>

			<div class="black-overlay"></div>

		</div>

		<div class="action-inputs">

			<button class="suggest-button" data-toggle="modal" data-target="#requirement-invite-modal">Suggest someone you know</button>

			<button class="fill-button" data-requirement-id="{{ $requirement['id'] }}">Step forward to fill this requirement</button>
		
		</div>

		<div class="requirement-item">

			<h3>{{ $requirement['item'] }}</h3>
			<p>
				@if (isset($requirementFilled))
					@if ($requirementFilled->user->id == Auth::user()->id)
						<a href="#" onClick="confirm('Remove yourself from this requirement?')">You have filled this requirement (undo)</a>
					@else
						<a href="{{ action('UserController@profile', $requirementFilled->user) }}">{{ $requirementFilled->user->name }}</a>
					@endif
				@else
					<span class="user-not-filled">Requirement not filled</span>
					<a class="user-filled" style="display:none" href="#" onClick="confirm('Remove yourself from this requirement?')">You have filled this requirement (undo)</a>
				@endif
			</p>
			
		</div>

	</div>

</li>