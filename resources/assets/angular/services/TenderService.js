XMovement.service('TenderService', function($http, $q) {
	return {
		'getTender': function(query) {
			var defer = $q.defer();
			$http.get('/api/tender', { params: query }).success(function(resp){
				defer.resolve(resp);
			}).error( function(err) {
				defer.reject(err);
			});
			return defer.promise;
		}
	}})
