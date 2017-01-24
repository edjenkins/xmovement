XMovement.service('InspirationService', function($http, $q) {
	return {
		'getInspiration': function(query) {
			var defer = $q.defer();
			$http.get('/api/inspiration', { params: query }).then(function successCallback(response) {
				defer.resolve(response.data);
			}, function errorCallback(err) {
				defer.reject(err);
			});
			return defer.promise;
		},
		'getInspirations': function(query) {
			var defer = $q.defer();
			$http.get('/api/inspirations', { params: query }).then(function successCallback(response) {
				defer.resolve(response.data);
			}, function errorCallback(err) {
				defer.reject(err);
			});
			return defer.promise;
		},
		'addInspiration': function(body) {
			var defer = $q.defer();
			$http.post('/api/inspiration/add', body).then(function successCallback(response) {
				defer.resolve(response.data);
			}, function errorCallback(err) {
				defer.reject(err);
			});
			return defer.promise;
		},
		'favouriteInspiration': function(body) {
			var defer = $q.defer();
			$http.post('/api/inspiration/favourite', body).then(function successCallback(response) {
				defer.resolve(response.data);
			}, function errorCallback(err) {
				defer.reject(err);
			});
			return defer.promise;
		},
		'reportInspiration': function(body) {
			var defer = $q.defer();
			$http.post('/api/report', body).then(function successCallback(response) {
				defer.resolve(response.data);
			}, function errorCallback(err) {
				defer.reject(err);
			});
			return defer.promise;
		},
		'deleteInspiration': function(body) {
			var defer = $q.defer();
			$http.post('/api/inspiration/delete', body).then(function successCallback(response) {
				defer.resolve(response.data);
			}, function errorCallback(err) {
				defer.reject(err);
			});
			return defer.promise;
		}
	}})
