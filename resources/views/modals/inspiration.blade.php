<div class="modal wide-modal fade" id="inspiration-modal" tabindex="-1" role="dialog">

	<div class="modal-dialog" role="document">

		<div class="modal-content">

			<div class="modal-body">

				<div ng-show="selected_inspiration.type == 'video'" class="video-preview-wrapper embed-responsive embed-responsive-16by9">
					<iframe class="embed-responsive-item" ng-src="<% setIframeUrl(selected_inspiration.content.embed) %>"></iframe>
				</div>

				<div ng-show="selected_inspiration.type == 'photo'" class="photo-preview-wrapper">
					<img style="width:100%" src="https://s3.amazonaws.com/xmovement/uploads/images/large/<% selected_inspiration.content %>"></img>
				</div>

				<div ng-show="selected_inspiration.type == 'file'" class="file-preview-wrapper">
					<i class="fa fa-file-text-o"></i>
					<a href="https://s3.amazonaws.com/xmovement/uploads/files/<% selected_inspiration.content %>"><% selected_inspiration.content %></a>
				</div>

				<div ng-show="selected_inspiration.type == 'link'" class="link-preview-wrapper">
					<i class="fa fa-link"></i>
					<a href="<% selected_inspiration.content %>"><% selected_inspiration.content %></a>
				</div>

				<br>

				<p>
					<% selected_inspiration.description %>
				</p>

			</div>

			<div class="comments-section">

				@include('discussion')

			</div>

		</div>

	</div>

</div>
