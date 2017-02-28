XMovement.service('DiscussionService', function($http, $q) {
	return {
		'fetchComments': function(query) {
			var defer = $q.defer();
			$http.get('/api/comment/view', { params: query }).then(function successCallback(response) {
				defer.resolve(response.data);
			}, function errorCallback(err) {
				defer.reject(err);
			});
			return defer.promise;
		}
	}})
