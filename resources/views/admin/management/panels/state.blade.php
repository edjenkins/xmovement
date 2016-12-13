<div class="admin-panel" id="state-admin-panel" ng-switch-when="state" ng-init="">

	<div class="col-md-6">

		<div class="admin-tile">

			<div class="admin-tile--label">Enabled Phases</div>

			<table class="table table-bordered">
				<col />
				<col width="100px" />
				<tr>
					<th>Phase</th>
					<th class="state-table-header">State</th>
				</tr>
				<tr xm-config-setting xm-config="{type:'boolean',title:'Inspiration',key:'INSPIRATION_PHASE_ENABLED'}"></tr>
				<tr xm-config-setting xm-config="{type:'boolean',title:'Creation',key:'CREATION_PHASE_ENABLED'}"></tr>
				<tr xm-config-setting xm-config="{type:'boolean',title:'Shortlist',key:'SHORTLIST_ENABLED'}"></tr>
				<tr xm-config-setting xm-config="{type:'boolean',title:'Tender',key:'TENDER_PHASE_ENABLED'}"></tr>
			</table>

		</div>

	</div>

	<div class="col-md-6">

		<div class="admin-tile">

			<div class="admin-tile--label">Process</div>

			<table class="table table-bordered">
				<col />
				<col width="100px" />
				<tr>
					<th>Setting</th>
					<th class="state-table-header">State</th>
				</tr>
				<tr xm-config-setting xm-config="{type:'integer',title:'Fixed idea duration (in days)',key:'FIXED_IDEA_DURATION'}"></tr>
				<!-- <tr>
					<td>Fixed idea duration (in days)</td>
					<td class="state-table-cell">{{ config('deployment.FIXED_IDEA_DURATION', 0) }}</td>
				</tr> -->
			</table>

			<p></p>

		</div>

	</div>

</div>
