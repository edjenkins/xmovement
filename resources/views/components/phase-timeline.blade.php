<!-- <div class="process-dates">
	<div class="process-date process-start-date">
		<xm-date-picker xm-config="$ctrl.milestones.start" xm-identifier="start" xm-phase-timeline-ctrl="$ctrl"></xm-date-picker>
	</div>

	<div class="clearfloat"></div>
</div> -->

<div class="process-timeline">

	<div class="grid"></div>

	<div class="key-dates">
		<div class="key-date start-date" style="left:<% $ctrl.milestones.start.offset %>px">
			<p class="key-date-label">
				<span class="key-date-label-label">Start</span>
				<span class="key-date-label-timestamp"><% $ctrl.milestones.start.date | date:'MMM d, y' %></span>
			</p>
		</div>
		<div class="key-date current-date" style="left:<% $ctrl.milestones.current.offset %>px">
			<p class="key-date-label">
				<span class="key-date-label-label">Now</span>
				<span class="key-date-label-timestamp"><% $ctrl.milestones.current.date | date:'MMM d, y' %></span>
			</p>
		</div>
		<div class="key-date end-date" style="left:<% $ctrl.milestones.end.offset %>px">
			<p class="key-date-label">
				<span class="key-date-label-label">End</span>
				<span class="key-date-label-timestamp"><% $ctrl.milestones.end.date | date:'MMM d, y' %></span>
			</p>
		</div>
	</div>

	<div class="tab-container">

		<div ng-repeat="phase in $ctrl.phases">
			<xm-phase xm-phase-timeline-item="phase" xm-phase-timeline-ctrl="$ctrl"></xm-phase>
		</div>

	</div>

</div>

<ul class="process-timeline-alerts">
	<li class="process-timeline-alert" ng-repeat="message in $ctrl.messages">
	  	<% message %>
	</li>
</ul>
