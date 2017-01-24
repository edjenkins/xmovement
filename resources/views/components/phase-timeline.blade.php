<!-- <div class="process-dates">
	<div class="process-date process-start-date">
		<xm-date-picker xm-config="$ctrl.milestones.start" xm-identifier="start" xm-phase-timeline-ctrl="$ctrl"></xm-date-picker>
	</div>

	<div class="clearfloat"></div>
</div> -->

<div class="process-timeline">

	<div class="grid"></div>

	<div class="key-dates">

		<div ng-repeat="milestone in $ctrl.milestones" class="key-date <% milestone.classes %>" style="left:<% milestone.offset %>px">
			<p class="key-date-label">
				<span class="key-date-label-label"><% milestone.placeholder %></span>
				<span class="key-date-label-timestamp"><% milestone.date * 1000 | date:'MMM d, y' %></span>
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

<br>
<button class="btn btn-xs btn-default" type="button" name="button" ng-click="$ctrl.updatePhases()">Validate Timeline</button>
