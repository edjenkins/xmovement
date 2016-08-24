XMovement.service('InspirationService', function($http, $q) {
	return {
		'getInspirations': function(query) {
			var defer = $q.defer();
			$http.get('/api/inspirations', { params: query }).success(function(resp){
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
		'favouriteInspiration': function(body) {
			var defer = $q.defer();
			$http.post('/api/inspiration/favourite', body).success(function(resp){
				defer.resolve(resp);
			}).error( function(err) {
				defer.reject(err);
			});
			return defer.promise;
		},
		'reportInspiration': function(body) {
			var defer = $q.defer();
			$http.post('/api/report', body).success(function(resp){
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
