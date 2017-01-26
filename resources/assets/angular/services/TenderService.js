XMovement.service('TenderService', function($http, $q) {
	return {
		'getTender': function(query) {
			var defer = $q.defer();
			$http.get('/api/tender', { params: query }).then(function successCallback(response) {
				defer.resolve(response.data);
			}, function errorCallback(err) {
				defer.reject(err);
			});
			return defer.promise;
		}
	}})
