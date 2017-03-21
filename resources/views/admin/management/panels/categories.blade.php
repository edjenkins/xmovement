<div class="admin-panel" id="categories-admin-panel" ng-switch-when="categories" ng-init="">

	<div class="col-md-6">

		<div class="admin-tile">
			<div class="admin-tile--label">Add Category</div>

			<form ng-init="new_category = {name: ''}">
				<div class="form-group">
					<label class="sr-only" for="category_name">Category name</label>
					<div class="input-group">
						<input type="text" class="form-control" id="category_name" placeholder="Category name" ng-model="new_category.name">
					</div>
				</div>
				<div class="form-group">
					<label class="sr-only" for="category_parent_id">Parent ID</label>
					<div class="input-group">
						<input type="text" class="form-control" id="category_parent_id" placeholder="Parent ID" ng-model="new_category.parent_id">
					</div>
				</div>
				<button type="submit" class="btn btn-primary" ng-click="addCategory(new_category)">Add Category</button>
			</form>

		</div>

	</div>

	<div class="col-md-6">

		<div class="admin-tile">
			<div class="admin-tile--label">Manage Categories</div>

			<ul class="list-group" ng-repeat="category in idea_categories" ng-init="category.visible = false">
				<li class="list-group-item">

					<strong><% category.name %></strong><span> - <% category.id %></span>

					<div class="dropdown pull-right">

						<i class="dropdown-toggle fa fa-fw fa-ellipsis-h" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"></i>

						<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
							<li><a ng-click="new_category.parent_id = category.id">Add Child</a></li>
							<li><a ng-click="deleteCategory(category.id)">Delete</a></li>
						</ul>

					</div>
				</li>
				<li ng-repeat="subcategory in category.subcategories" class="list-group-item">

					<% subcategory.name %>

					<div class="dropdown pull-right">

						<i class="dropdown-toggle fa fa-fw fa-ellipsis-h" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"></i>

						<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
							<li><a ng-click="updateCategory(subcategory.id, subcategory.name, 0)">Make Parent</a></li>
							<li><a ng-click="deleteCategory(subcategory.id)">Delete</a></li>
						</ul>

					</div>
				</li>
			</ul>

		</div>

	</div>

</div>

<script type="text/javascript">
	$(document).ready(function() {
		$('.dropdown-toggle').dropdown();
	})
</script>
