<div class="category-picker">

	<!-- Input field used in forms -->
	<input type="hidden" name="category" id="category-input-field" value="<% $ctrl.selected_category.id %>">
	<!-- Button to open overlay -->
	<button class="category-button" type="button" ng-click="$ctrl.selecting_category = true" ng-cloak>
		<% $ctrl.selected_category.name || 'Select Category' %>
		<i ng-if="$ctrl.selected_category" class="fa fa-caret-down"></i>
	</button>

	<!-- Cateogries overlay -->
	<div class="categories-overlay" ng-class="{'visible':$ctrl.selecting_category}">

		<div class="categories-container">

			<div class="close-categories-overlay" ng-click="$ctrl.selecting_category = false">
				{{ trans('common.close') }}
			</div>

			<ul class="primary-categories">

				<li class="primary-category fadeIn animated">
					<a ng-click="$ctrl.setCategory(undefined)">
						{{ trans('common.show_all') }}
					</a>
				</li>

				<span ng-repeat="category in $ctrl.categories">

					<li class="primary-category fadeIn animated" ng-show="($ctrl.populatedOnly == 'false') || (category.ideas_count > 0)">
						<a ng-click="$ctrl.setCategory(category)">
							<% category.name %>
						</a>
					</li>
					<li class="secondary-category fadeInUp animated" ng-show="(($ctrl.populatedOnly === 'false') || (category.ideas_count > 0) && category.subcategories.length > 0)">
						<a ng-click="$ctrl.setCategory(category)">
							{{ trans('common.all') }}
						</a>
					</li>
					<li class="secondary-category fadeInUp animated" ng-repeat="subcategory in category.subcategories" ng-show="($ctrl.populatedOnly === 'false') || (subcategory.ideas_count > 0)">
						<a ng-click="$ctrl.setCategory(subcategory)">
							<% subcategory.name %>
						</a>
					</li>

					<div class="clearfloat"></div>

				</span>

			</ul>

		</div>

	</div>

</div>
