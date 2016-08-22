XMovement.service('InspirationService', function($http, $q) {
	return {
		'getInspirations': function() {
			var defer = $q.defer();
			$http.get('/api/inspirations').success(function(resp){
				defer.resolve(resp);
			}).error( function(err) {
				defer.reject(err);
			});
			return defer.promise;
		},
		'addInspiration': function(body) {
			var defer = $q.defer();
			$http.post('/api/inspiration/add', body).success(function(resp){
				defer.resolve(resp);
			}).error( function(err) {
				defer.reject(err);
			});
			return defer.promise;
		},
		'deleteInspiration': function(body) {
			var defer = $q.defer();
			$http.post('/api/inspiration/delete', body).success(function(resp){
				defer.resolve(resp);
			}).error( function(err) {
				defer.reject(err);
			});
			return defer.promise;
		}
	}})
