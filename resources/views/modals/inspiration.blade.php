<div class="modal wide-modal fade" id="inspiration-modal" tabindex="-1" role="dialog">

	<div class="modal-dialog" role="document">

		<div class="modal-content">

			<div class="modal-body">

				<div ng-show="selected_inspiration.type == 'video'" class="embed-responsive embed-responsive-16by9">
					<iframe class="embed-responsive-item" ng-src="<% setIframeUrl(selected_inspiration.content.embed) %>"></iframe>
				</div>

				<div ng-show="selected_inspiration.type == 'photo'">
					<img style="width:100%" src="https://s3.amazonaws.com/xmovement/uploads/images/large/<% selected_inspiration.content %>"></img>
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
