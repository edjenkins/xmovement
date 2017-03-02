<div class="modal wide-modal fade" id="inspiration-modal" tabindex="-1" role="dialog">

	<div class="modal-dialog" role="document">

		<div class="modal-content">

			<ul class="inspiration-header">

				<li class="pull-left inspiration-tag" ng-show="selected_inspiration.categories.length">
					<i class="fa fa-fw fa-tag"></i>

					<span ng-repeat="category in selected_inspiration.categories">
						<% category.name %>
					</span>
				</li>

				<li class="pull-right close-inspiration" data-dismiss="modal">
					<i class="fa fa-fw fa-times"></i>
				</li>

				<div class="clearfloat"></div>

			</ul>

			<div class="modal-body">

				<div ng-show="selected_inspiration.type == 'video'" class="video-preview-wrapper embed-responsive embed-responsive-16by9">
					<iframe class="embed-responsive-item" ng-src="<% setIframeUrl(selected_inspiration.content.embed) %>"></iframe>
				</div>

				<div ng-show="selected_inspiration.type == 'photo'" class="photo-preview-wrapper" style="padding-bottom: <%(( selected_inspiration.content.height / selected_inspiration.content.width) * 100) + '%' %>; background-image:url('<% (selected_inspiration.content.thumbnail.indexOf('http') == 0) ? selected_inspiration.content.thumbnail : 'https://s3.amazonaws.com/xmovement/uploads/images/large/' + selected_inspiration.content.thumbnail %>')" data-file-height="<% selected_inspiration.content.height %>" data-file-width="<% selected_inspiration.content.width %>"></div>

				<div ng-show="selected_inspiration.type == 'file'" class="file-preview-wrapper">
					<i class="fa fa-file-text-o"></i>
					<a target="_self" href="https://s3.amazonaws.com/xmovement/uploads/files/<% selected_inspiration.content %>"><% selected_inspiration.content %></a>
				</div>

				<div ng-show="selected_inspiration.type == 'link'" class="link-preview-wrapper">
					<i class="fa fa-link"></i>
					<a target="_self" href="<% selected_inspiration.content %>"><% selected_inspiration.content %></a>
				</div>

				<p class="inspiration-description">
					<% selected_inspiration.description %>
				</p>

			</div>

			<ul class="inspiration-toolbar">

				<li class="pull-left author-link">
					Shared by
					<a target="_self" href="/profile/<% selected_inspiration.user.id %>"><% selected_inspiration.user.name %></a>
				</li>

				<li class="pull-right inspiration-action" ng-click="reportInspiration(selected_inspiration)">
					<i class="fa fa-fw fa-flag"></i>
				</li>

				@if (Auth::guest())

					<li class="pull-right inspiration-action">
						<% selected_inspiration.favourited_count %> <i class="fa fa-fw fa-star"></i>
					</li>

				@else

					<li class="pull-right inspiration-action" ng-click="deleteInspiration(selected_inspiration)" ng-show="selected_inspiration.user.id == {{ Auth::user()->id }}">
						<i class="fa fa-fw fa-trash"></i>
					</li>

					<li class="pull-right inspiration-action" ng-click="favouriteInspiration(selected_inspiration)" ng-class="{ 'favourited' : selected_inspiration.has_favourited }">
						<% selected_inspiration.favourited_count %> <i class="fa fa-fw" ng-class="selected_inspiration.favouriting ? 'fa-spinner fa-pulse' : 'fa-star'"></i>
					</li>

				@endif

				<div class="clearfloat"></div>

			</ul>

			<div class="comments-section">

				@include('discussion', ['target_type' => 'Inspiration'])

			</div>

		</div>

	</div>

</div>
