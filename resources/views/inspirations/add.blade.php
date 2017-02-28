@can('create', App\Inspiration::class)
	<div class="side-panel-box submission-box">
		<div class="side-panel-box-header">
			Add Inspiration
		</div>
		<div class="side-panel-box-content" ng-init="submission_type = 'photo'">
			<ul class="submission-type-selector">
				<li ng-class="{'selected' : (submission_type == 'photo')}" ng-click="submission_type = 'photo'" onclick="setTimeout(function() { $('textarea').expanding() }, 100)"><i class="fa fa-camera"></i></li>
				<li ng-class="{'selected' : (submission_type == 'video')}" ng-click="submission_type = 'video'" onclick="setTimeout(function() { $('textarea').expanding() }, 100)"><i class="fa fa-video-camera"></i></li>
				<li ng-class="{'selected' : (submission_type == 'file')}" ng-click="submission_type = 'file'" onclick="setTimeout(function() { $('textarea').expanding() }, 100)"><i class="fa fa-file-text-o"></i></li>
				<li ng-class="{'selected' : (submission_type == 'link')}" ng-click="submission_type = 'link'" onclick="setTimeout(function() { $('textarea').expanding() }, 100)"><i class="fa fa-link"></i></li>
			</ul>

			<form class="" action="index.html" method="post" ng-show="submission_type == 'photo'">
				<div class="input-wrapper">
					@include('dropzone', ['type' => 'image', 'cc' => false, 'input_id' => 'dropzone-photo', 'value' => old('photo'), 'dropzone_id' => 1])
				</div>
				<div class="input-wrapper">
					<textarea class="expanding" rows="1" ng-model="new_inspiration['photo'].description" cols="40" placeholder="Photo Description"></textarea>
				</div>
				@foreach ($inspiration_categories as $inspiration_category)
					<label style="font-size: 13px; margin: 0px 5px 15px 5px;">
						<input type="radio" ng-model="new_inspiration['photo'].category" value="{{ $inspiration_category->id }}">
						{{ $inspiration_category->name }}
					</label>
				@endforeach
				<button ng-click="addInspiration('photo')" class="btn" type="button" name="button">Share Photo</button>
			</form>

			<form class="" action="index.html" method="post" ng-show="submission_type == 'video'">
				<div class="input-wrapper">
					<textarea class="expanding" rows="1" ng-model="new_inspiration['video'].content" cols="40" placeholder="YouTube URL"></textarea>
				</div>
				<div class="input-wrapper">
					<textarea class="expanding" rows="1" ng-model="new_inspiration['video'].description" cols="40" placeholder="Video Description"></textarea>
				</div>
				<button ng-click="addInspiration('video')" class="btn" type="button" name="button">Share Video</button>
			</form>

			<form class="" action="index.html" method="post" ng-show="submission_type == 'file'">
				<div class="input-wrapper">
					@include('dropzone', ['type' => 'file', 'cc' => false, 'input_id' => 'dropzone-file', 'value' => old('file'), 'dropzone_id' => 2])
				</div>
				<div class="input-wrapper">
					<textarea class="expanding" rows="1" ng-model="new_inspiration['file'].description" cols="40" placeholder="File Description"></textarea>
				</div>
				<button ng-click="addInspiration('file')" class="btn" type="button" name="button">Share File</button>
			</form>

			<form class="" action="index.html" method="post" ng-show="submission_type == 'link'">
				<div class="input-wrapper">
					<textarea class="expanding" rows="1" ng-model="new_inspiration['link'].content" cols="40" placeholder="Link URL"></textarea>
				</div>
				<div class="input-wrapper">
					<textarea class="expanding" rows="1" ng-model="new_inspiration['link'].description" cols="40" placeholder="Link Description"></textarea>
				</div>
				<button ng-click="addInspiration('link')" class="btn" type="button" name="button">Share Link</button>
			</form>
		</div>
	</div>
@endcan
