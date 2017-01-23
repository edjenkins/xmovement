<div class="date-picker-wrapper">
	<div class="date-picker-button">
		<div class="date-picker-button--label">
			NULL
		</div>
		<div class="date-picker-button--value">
			<% config.date | date:'MMM d, y' %>
		</div>
	</div>
	<input class="datepicker" type="text" ng-value="config.date" placeholder="NULL">
</div>
