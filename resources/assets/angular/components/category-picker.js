function CategoryPickerController($scope, $rootScope, $element, $attrs, $location, CategoryService) {

  var ctrl = this;

  ctrl.categories = [];
  ctrl.selected_category = undefined;
  ctrl.selecting_category = false;

  ctrl.getCategories = function() {

    CategoryService.getIdeaCategories().then(function(response) {

      ctrl.categories = response.data.categories;

      console.log(ctrl.categories);

      var result = _.find(ctrl.categories, function(o) {
        return o.id == $location.search()['category'];
      });

      console.log(result);

      if (result) {
        ctrl.setCategory(result);
      }
    });
  };

  ctrl.setCategory = function(category) {

    ctrl.selected_category = category;
    ctrl.selecting_category = false;

    $rootScope.$broadcast('CategoryPicker::categorySelected', category);
  }

  ctrl.getCategories();

}
CategoryPickerController.$inject = ['$scope', '$rootScope', '$element', '$attrs', '$location', 'CategoryService'];

XMovement.component('categoryPicker', {
  templateUrl: '/components/category-picker',
    bindings: {
        category: '@',
    populatedOnly : '@'
    },
  controller: CategoryPickerController
});
