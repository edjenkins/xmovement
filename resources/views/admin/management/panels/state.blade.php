<div class="admin-panel" id="state-admin-panel" ng-switch-when="state" ng-init="">

	<div class="col-md-12">

		<div class="admin-tile">

			<div class="admin-tile--label">Progression</div>

			<ul class="progression-selector">

				<!-- Timeline has all phases -->
				<li ng-class="{'selected':progression_type == 'fixed'}">
					<div class="inner-wrapper">
						<h5>Fixed</h5>
						<p class="progression-type-description">Progress through the phases on specific predefined dates.</p>
						<button ng-click="setProgressionType('fixed')" type="button">
							<% (progression_type == 'fixed') ? 'Selected' : 'Select' %>
						</button>
					</div>
				</li>

				<!-- No Shortlist, Tender, Inspiration in timeline -->
				<li ng-class="{'selected':progression_type == 'fluid'}">
					<div class="inner-wrapper">
						<h5>Fluid</h5>
						<p class="progression-type-description">Progress through the phases after specific predefined durations.</p>
						<button ng-click="setProgressionType('fluid')" type="button">
							<% (progression_type == 'fluid') ? 'Selected' : 'Select' %>
						</button>
					</div>
				</li>

				<!-- Selectable preset durations for creation/design process -->
				<li ng-class="{'selected':progression_type == 'user-defined'}">
					<div class="inner-wrapper">
						<h5>User Defined</h5>
						<p class="progression-type-description">Progress through the phases after user defined durations.</p>
						<button ng-click="setProgressionType('user-defined')" type="button">
							<% (progression_type == 'user-defined') ? 'Selected' : 'Select' %>
						</button>
					</div>
				</li>

				<div class="clearfloat"></div>

			</ul>

		</div>

	</div>

	<div class="col-md-12" ng-if="progression_type == 'user-defined'">

		<div class="admin-tile">

			<div class="admin-tile--label">Phase Durations</div>

			<div class="col-md-4">

				<table class="table table-bordered table-with-margin">
					<col />
					<col width="100px" />
					<tr>
						<th>Short</th>
						<th class="state-table-header">Duration</th>
					</tr>
					<tr xm-config-setting xm-config="{type:'integer',title:'Support Duration',key:'SHORT_SUPPORT_DURATION'}" xm-phase-timeline-ctrl="$ctrl"></tr>
					<tr xm-config-setting xm-config="{type:'integer',title:'Design Duration',key:'SHORT_DESIGN_DURATION'}" xm-phase-timeline-ctrl="$ctrl"></tr>
					<tr xm-config-setting xm-config="{type:'boolean',title:'Enabled',key:'SHORT_DURATION_ENABLED'}" xm-phase-timeline-ctrl="$ctrl"></tr>
				</table>

			</div>

			<div class="col-md-4">

				<table class="table table-bordered table-with-margin">
					<col />
					<col width="100px" />
					<tr>
						<th>Medium</th>
						<th class="state-table-header">Duration</th>
					</tr>
					<tr xm-config-setting xm-config="{type:'integer',title:'Support Duration',key:'MEDIUM_SUPPORT_DURATION'}" xm-phase-timeline-ctrl="$ctrl"></tr>
					<tr xm-config-setting xm-config="{type:'integer',title:'Design Duration',key:'MEDIUM_DESIGN_DURATION'}" xm-phase-timeline-ctrl="$ctrl"></tr>
					<tr xm-config-setting xm-config="{type:'boolean',title:'Enabled',key:'MEDIUM_DURATION_ENABLED'}" xm-phase-timeline-ctrl="$ctrl"></tr>
				</table>

			</div>

			<div class="col-md-4">

				<table class="table table-bordered table-with-margin">
					<col />
					<col width="100px" />
					<tr>
						<th>Long</th>
						<th class="state-table-header">Duration</th>
					</tr>
					<tr xm-config-setting xm-config="{type:'integer',title:'Support Duration',key:'LONG_SUPPORT_DURATION'}" xm-phase-timeline-ctrl="$ctrl"></tr>
					<tr xm-config-setting xm-config="{type:'integer',title:'Design Duration',key:'LONG_DESIGN_DURATION'}" xm-phase-timeline-ctrl="$ctrl"></tr>
					<tr xm-config-setting xm-config="{type:'boolean',title:'Enabled',key:'LONG_DURATION_ENABLED'}" xm-phase-timeline-ctrl="$ctrl"></tr>
				</table>

			</div>

			<div class="clearfloat"></div>

		</div>

	</div>

	<div class="col-md-12" ng-if="progression_type != 'user-defined'">

		<div class="admin-tile">

			<div class="admin-tile--label">Timeline</div>

			<phase-timeline></phase-timeline>

		</div>

	</div>

	<div class="col-md-6" ng-switch="progression_type">
		<div ng-switch-when="fixed">

			<div class="admin-tile">
				<div class="admin-tile--label">Fixed Options</div>

				<table class="table table-bordered">
					<col />
					<col width="100px" />
					<tr>
						<th>Setting</th>
						<th class="state-table-header">State</th>
					</tr>
					<tr xm-config-setting xm-config="{type:'boolean',title:'Limit Tendering to Shortlist',key:'TENDER_SHORTLIST_ONLY'}" xm-phase-timeline-ctrl="$ctrl"></tr>
					<tr xm-config-setting xm-config="{type:'timestamp',title:'Process Start Date',key:'PROCESS_START_DATE'}" xm-phase-timeline-ctrl="$ctrl"></tr>
				</table>

			</div>

		</div>
		<div ng-switch-when="fluid">

			<div class="admin-tile">
				<div class="admin-tile--label">Fluid Options</div>

				<table class="table table-bordered">
					<col />
					<col width="100px" />
					<tr>
						<th>Setting</th>
						<th class="state-table-header">State</th>
					</tr>
					<tr xm-config-setting xm-config="{type:'boolean',title:'Limit Tendering to Shortlist',key:'TENDER_SHORTLIST_ONLY'}" xm-phase-timeline-ctrl="$ctrl"></tr>
				</table>
			</div>

		</div>
		<div ng-switch-when="user-defined">

			<div class="admin-tile">
				<div class="admin-tile--label">User Defined Options</div>

				<table class="table table-bordered">
					<col />
					<col width="100px" />
					<tr>
						<th>Setting</th>
						<th class="state-table-header">State</th>
					</tr>
					<!-- <tr xm-config-setting xm-config="{type:'boolean',title:'Limit Tendering to Shortlist',key:'TENDER_SHORTLIST_ONLY'}" xm-phase-timeline-ctrl="$ctrl"></tr> -->
					<tr xm-config-setting xm-config="{type:'integer',title:'Minimum supporter count to progress',key:'MIN_SUPPORTER_COUNT'}" xm-phase-timeline-ctrl="$ctrl"></tr>
				</table>

			</div>

		</div>
	</div>

	<div class="col-md-6">

		<div class="admin-tile">

			<div class="admin-tile--label">Phases</div>
			<p>Automatically enable/disable phases over time</p>
			<table class="table table-bordered">
				<col />
				<col width="100px" />
				<tr>
					<th>Phase</th>
					<th class="state-table-header">State</th>
				</tr>
				<tr ng-if="progression_type == 'fixed'" xm-config-setting xm-config="{type:'boolean',title:'Inspiration',key:'INSPIRATION_PHASE_ENABLED'}" xm-phase-timeline-ctrl="$ctrl"></tr>
				<tr xm-config-setting xm-config="{type:'boolean',title:'Tender',key:'TENDER_PHASE_ENABLED'}" xm-phase-timeline-ctrl="$ctrl"></tr>
			</table>

		</div>

		<div class="admin-tile">

			<div class="admin-tile--label">Modes</div>

			<table class="table table-bordered">
				<col />
				<col width="100px" />
				<tr>
					<th>Mode</th>
					<th class="state-table-header">State</th>
				</tr>
				<tr xm-config-setting xm-config="{type:'boolean',title:'Inspiration Mode',key:'INSPIRATION_MODE_ENABLED'}" xm-phase-timeline-ctrl="$ctrl"></tr>
				<tr ng-if="progression_type != 'fixed'" xm-config-setting xm-config="{type:'boolean',title:'Creation Mode',key:'CREATION_MODE_ENABLED'}" xm-phase-timeline-ctrl="$ctrl"></tr>
				<tr xm-config-setting xm-config="{type:'boolean',title:'Shortlist Mode',key:'SHORTLIST_MODE_ENABLED'}" xm-phase-timeline-ctrl="$ctrl"></tr>
			</table>

		</div>

	</div>

</div>
