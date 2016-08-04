<div class="analytics-panel" id="users-analytics-panel" ng-switch-when="users" ng-init="users.order_type = 'name'; users.reverse = false">

	<table border="1">
		<tr>
			<th ng-repeat="header in headers.users" ng-click="users.order_type = header.type; users.reverse = !users.reverse">
				<% header.name %>
				<i class="fa" ng-class="users.reverse ? 'fa-caret-down' : 'fa-caret-up'" ng-show="users.order_type == header.type"></i>
			</th>
		</tr>

		<tbody ng-repeat="user in users | orderBy:users.order_type:users.reverse">
			<tr>
				<td><% user.name %></td>
				<td><% user.email %></td>
				<td><% user.created_at %></td>
				<td class="expandable" ng-click="toggleDetailRow(user, 'ideas')" ng-class="{'highlighted' : user.visible_detail_row == 'ideas'}"><% user.ideas.length %></td>
				<td class="expandable" ng-click="toggleDetailRow(user, 'design_tasks')" ng-class="{'highlighted' : user.visible_detail_row == 'design_tasks'}"><% user.design_tasks.length %></td>
				<td><% user.design_task_votes.length %></td>
				<td class="expandable" ng-click="toggleDetailRow(user, 'proposals')" ng-class="{'highlighted' : user.visible_detail_row == 'proposals'}"><% user.proposals.length %></td>
				<td class="expandable" ng-click="toggleDetailRow(user, 'comments')" ng-class="{'highlighted' : user.visible_detail_row == 'comments'}"><% user.comments.length %></td>
			</tr>
			<tr class="detail-row">
				<td colspan="8" ng-show="user.visible_detail_row == 'ideas'">
					<ul>
						<li ng-repeat="idea in user.ideas">
							<a href="/idea/<% idea.id %>">
								<% idea.name %>
							</a>
						</li>
					</ul>
				</td>
				<td colspan="8" ng-show="user.visible_detail_row == 'design_tasks'">
					<ul>
						<li ng-repeat="design_task in user.design_tasks">
							<a href="/design/<% design_task.xmovement_task_type.toLowerCase() %>/<% design_task.id %>">
								<% design_task.name %>
							</a>
						</li>
					</ul>
				</td>
				<td colspan="8" ng-show="user.visible_detail_row == 'proposals'">
					<ul>
						<li ng-repeat="proposal in user.proposals">
							<a href="/propose/view/<% proposal.id %>" target="_blank">
								<% proposal.description %>
							</a>
						</li>
					</ul>
				</td>
				<td colspan="8" ng-show="user.visible_detail_row == 'comments'">
					<ul>
						<li ng-repeat="comment in user.comments">
							<a href="<% comment.url %>" target="_blank">
								<% comment.text %>
							</a>
						</li>
					</ul>
				</td>
			</tr>
		</tbody>

	</table>

</div>
