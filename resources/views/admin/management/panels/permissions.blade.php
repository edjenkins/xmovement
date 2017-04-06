<div class="admin-panel" id="permissions-admin-panel" ng-switch-when="permissions" ng-init="">

	<div class="col-md-12">

		<div class="admin-tile">

			<div class="admin-tile--label">Add Administrator</div>

			<div class="add-admin-form-container" ng-class="{'has-results':(user_search_results.length > 0)}">

				<form class="auth-form add-admin-form" role="form" method="POST" action="">

					<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">

						<input type="text" class="form-control add-admin-search" name="name" ng-model="user_search_query" placeholder="{{ trans('admin.user_search_placeholder') }}" ng-change="searchUsers(user_search_query)">

						<div class="searching-users" ng-init="searching_users = false" ng-show="searching_users">
							<i class="fa fa-spin fa-refresh"></i>
						</div>
					</div>

				</form>

				<ul class="user-results" ng-show="(user_search_results.length > 0)">


					<table class="table table-bordered">
						<col />
						<col width="100px" />
						<tr>
							<th>User</th>
							<th class="state-table-header">Super Admin</th>
							<th class="state-table-header">Admin</th>
							<th class="state-table-header">Manage Admins</th>
							<th class="state-table-header">Manage Platform</th>
							<th class="state-table-header">Manage State</th>
							<th class="state-table-header">Manage Categories</th>
							<th class="state-table-header">Translate Platform</th>
							<th class="state-table-header">View Analytics</th>
						</tr>
						<tr xm-config-user ng-repeat="user in user_search_results" xm-user="user"></tr>
					</table>

				</ul>

			</div>

		</div>

		<div class="admin-tile">

			<div class="admin-tile--label">Administrators</div>

			<table class="table table-bordered">
				<col />
				<col width="100px" />
				<tr>
					<th>User</th>
					<th class="state-table-header">Super Admin</th>
					<th class="state-table-header">Admin</th>
					<th class="state-table-header">Manage Admins</th>
					<th class="state-table-header">Manage Platform</th>
					<th class="state-table-header">Manage State</th>
					<th class="state-table-header">Manage Categories</th>
					<th class="state-table-header">Translate Platform</th>
					<th class="state-table-header">View Analytics</th>
				</tr>
				<tr xm-config-user ng-repeat="user in admins" xm-user="user"></tr>
			</table>

		</div>

	</div>

</div>
