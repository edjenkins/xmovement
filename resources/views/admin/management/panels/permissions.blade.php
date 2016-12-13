<div class="admin-panel" id="permissions-admin-panel" ng-switch-when="permissions" ng-init="">

	<div class="col-md-6">

		<div class="admin-tile">

			<div class="admin-tile--label">Administrators</div>

			<table class="table table-bordered">
				<col />
				<col width="100px" />
				<tr>
					<th>User</th>
					<th class="state-table-header">Admin</th>
					<th class="state-table-header">Translate</th>
					<th class="state-table-header">Analytics</th>
				</tr>
				<tr xm-config-user ng-repeat="user in users" xm-user="user"></tr>
			</table>

		</div>

	</div>

</div>
