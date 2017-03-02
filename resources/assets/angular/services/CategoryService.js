XMovement.service('CategoryService', function($http, $q) {
	return {
		'getIdeaCategories': function(query) {
			var defer = $q.defer();
			$http.get('/api/categories/idea').then(function successCallback(response) {
				defer.resolve(response.data);
			}, function errorCallback(err) {
				defer.reject(err);
			});
			return defer.promise;
		}
	}})
