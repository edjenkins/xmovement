XMovement.service('ExploreService', function($http, $q) {
	return {
		'getIdeas': function(query) {
			var defer = $q.defer();
			$http.get('/api/ideas', { params: query }).success(function(resp){
				defer.resolve(resp);
			}).error( function(err) {
				defer.reject(err);
			});
			return defer.promise;
		}
	}})
