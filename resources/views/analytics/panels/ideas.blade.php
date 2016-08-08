<div class="analytics-panel" id="ideas-analytics-panel" ng-switch-when="ideas" ng-init="ideas.order_type = 'name'; ideas.reverse = false">

	<table border="1">
		<tr>
			<th ng-repeat="header in headers.ideas" ng-click="ideas.order_type = header.type; ideas.reverse = !ideas.reverse">
				<% header.name %>
				<i class="fa" ng-class="ideas.reverse ? 'fa-caret-down' : 'fa-caret-up'" ng-show="ideas.order_type == header.type"></i>
			</th>
		</tr>
		<tbody ng-repeat="idea in ideas | orderBy:ideas.order_type:ideas.reverse">
			<tr>
				<td><% idea.name %></td>
				<td><% idea.user.name %></td>
				<td><% idea.supporters.length | number : 0 %></td>
				<td class="expandable" ng-click="toggleDetailRow(idea, 'proposals')" ng-class="{'highlighted' : idea.visible_detail_row == 'proposals'}"><% idea.proposals.length | number : 0 %></td>
				<td class="expandable" ng-click="toggleDetailRow(idea, 'comments')" ng-class="{'highlighted' : idea.visible_detail_row == 'comments'}"><% idea.comments.length | number : 0 %></td>
				<td><% idea.duration | number : 0 %></td>
				<td class="expandable" ng-click="toggleDetailRow(idea, 'design_tasks')" ng-class="{'highlighted' : idea.visible_detail_row == 'design_tasks'}"><% idea.design_tasks.length | number : 0 %></td>
				<td><% idea.progress | number : 0 %>%</td>
				<td class="expandable" ng-click="toggleDetailRow(idea, 'share_button_clicks')" ng-class="{'highlighted' : idea.visible_detail_row == 'share_button_clicks'}"><% idea.share_button_clicks.length | number : 0  %></td>
				<td><% idea.created_at %></td>
			</tr>
			<tr class="detail-row">
				<td colspan="<% headers.ideas.length %>" ng-show="idea.visible_detail_row == 'proposals'">
					<ul>
						<li ng-repeat="proposal in idea.proposals">
							<a href="/propose/view/<% proposal.id %>" target="_blank">
								<% proposal.description %>
							</a>
						</li>
					</ul>
				</td>
				<td colspan="<% headers.ideas.length %>" ng-show="idea.visible_detail_row == 'comments'">
					<ul>
						<li ng-repeat="comment in idea.comments">
							<a href="<% comment.url %>" target="_blank">
								<% comment.text %>
							</a>
						</li>
					</ul>
				</td>
				<td colspan="<% headers.ideas.length %>" ng-show="idea.visible_detail_row == 'design_tasks'">
					<ul>
						<li ng-repeat="design_task in idea.design_tasks">
							<a href="/design/<% design_task.xmovement_task_type.toLowerCase() %>/<% design_task.id %>">
								<% design_task.name %>
							</a>
						</li>
					</ul>
				</td>
				<td colspan="<% headers.ideas.length %>" ng-show="idea.visible_detail_row == 'share_button_clicks'">
					<ul>
						<li ng-repeat="share_button_click in idea.share_button_clicks | orderBy:share_button_click.label">
							<span ng-switch="share_button_click.label">
								<span ng-switch-when="facebook-share-button-click"><i class="fa fa-facebook"></i> Facebook Share</span>
								<span ng-switch-when="twitter-share-button-click"><i class="fa fa-twitter"></i> Twitter Share</span>
								<span ng-switch-when="googleplus-share-button-click"><i class="fa fa-googleplus"></i> Google Plus Share</span>
								<span ng-switch-when="email-share-button-click"><i class="fa fa-envelope"></i> Email Share</span>
							</span>
						</li>
					</ul>
				</td>
			</tr>
		</tbody>
	</table>

</div>
