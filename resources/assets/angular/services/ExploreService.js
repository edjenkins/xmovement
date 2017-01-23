XMovement.service('ExploreService', function($http, $q) {
	return {
		'getIdeas': function(query) {
			var defer = $q.defer();
			$http.get('/api/ideas', { params: query }).then(function successCallback(response) {
				defer.resolve(response.data);
			}, function errorCallback(err) {
				defer.reject(err);
			});
			return defer.promise;
		}
	}})
