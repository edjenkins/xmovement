<div class="admin-panel" id="general-admin-panel" ng-switch-when="general" ng-init="">

	<div class="col-md-6">

		<div class="admin-tile">

			<div class="admin-tile--label">Design modules</div>

			<table class="table table-bordered">
				<col />
				<col width="100px" />
				<tr>
					<th>Module</th>
					<th class="state-table-header">Enabled</th>
				</tr>
				<tr xm-config-setting xm-config="{type:'boolean',title:'Scheduler',key:'XMOVEMENT_SCHEDULER'}"></tr>
				<tr xm-config-setting xm-config="{type:'boolean',title:'Poll',key:'XMOVEMENT_POLL'}"></tr>
				<tr xm-config-setting xm-config="{type:'boolean',title:'Requirement',key:'XMOVEMENT_REQUIREMENT'}"></tr>
				<tr xm-config-setting xm-config="{type:'boolean',title:'Contribution',key:'XMOVEMENT_CONTRIBUTION'}"></tr>
				<tr xm-config-setting xm-config="{type:'boolean',title:'External',key:'XMOVEMENT_EXTERNAL'}"></tr>
				<tr xm-config-setting xm-config="{type:'boolean',title:'Discussion',key:'XMOVEMENT_DISCUSSION'}"></tr>
			</table>

			<p class="text-muted">Please contact deployment administrator to activate modules.</p>

		</div>

	</div>

	<div class="col-md-6">

		<div class="admin-tile">

			<div class="admin-tile--label">Idea creation</div>

			<table class="table table-bordered">
				<col />
				<col width="100px" />
				<tr>
					<th>Setting</th>
					<th class="state-table-header">State</th>
				</tr>
				<tr xm-config-setting xm-config="{type:'boolean',title:'Pre populate design tasks',key:'PRE_POPULATE_DESIGN_TASKS'}"></tr>
				<tr xm-config-setting xm-config="{type:'boolean',title:'Allow users to pre populate design tasks',key:'ALLOW_USER_TO_PRE_POPULATE_DESIGN_TASKS'}"></tr>
			</table>

		</div>

	</div>

</div>
