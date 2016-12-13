<td><% user.name %></td>
<td ng-class="{'state-enabled':user.super_admin, 'state-disabled':!user.super_admin}" class="state-table-cell">
	<span ng-click="user.super_admin = !user.super_admin; configController.updatePermission($event, 'super_admin')">
		<i ng-show="(user.super_admin == null)" class="fa fa-spinner fa-pulse"></i>
		<i ng-show="(user.super_admin != null)" class="fa fa-circle"></i>
	</span>
</td>

<td ng-class="{'state-enabled':user.can_translate, 'state-disabled':!user.can_translate}" class="state-table-cell">
	<span ng-click="user.can_translate = !user.can_translate; configController.updatePermission($event, 'can_translate')">
		<i ng-show="(user.can_translate == null)" class="fa fa-spinner fa-pulse"></i>
		<i ng-show="(user.can_translate != null)" class="fa fa-circle"></i>
	</span>
</td>

<td ng-class="{'state-enabled':user.can_view_analytics, 'state-disabled':!user.can_view_analytics}" class="state-table-cell">
	<span ng-click="user.can_view_analytics = !user.can_view_analytics; configController.updatePermission($event, 'can_view_analytics')">
		<i ng-show="(user.can_view_analytics == null)" class="fa fa-spinner fa-pulse"></i>
		<i ng-show="(user.can_view_analytics != null)" class="fa fa-circle"></i>
	</span>
</td>
