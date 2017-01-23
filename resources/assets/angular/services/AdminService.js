XMovement.service('AdminService', function($http, $q) {
	return {
		'updateConfig': function(body) {
			var defer = $q.defer();
			$http.post('/admin/config/update', body).then(function successCallback(response) {
				defer.resolve(response.data);
			}, function errorCallback(err) {
				defer.reject(err);
			});
			return defer.promise;
		},
		'fetchConfig': function(body) {
			var defer = $q.defer();
			$http.post('/admin/config/fetch', body).then(function successCallback(response) {
				defer.resolve(response.data);
			}, function errorCallback(err) {
				defer.reject(err);
			});
			return defer.promise;
		},
		'updatePermission': function(body) {
			var defer = $q.defer();
			$http.post('/admin/permissions/update', body).then(function successCallback(response) {
				defer.resolve(response.data);
			}, function errorCallback(err) {
				defer.reject(err);
			});
			return defer.promise;
		},
		'fetchPermission': function(body) {
			var defer = $q.defer();
			$http.post('/admin/permissions/fetch', body).then(function successCallback(response) {
				defer.resolve(response.data);
			}, function errorCallback(err) {
				defer.reject(err);
			});
			return defer.promise;
		},
		'updatePhases': function(body) {
			var defer = $q.defer();
			$http.post('/admin/phases/update', body).then(function successCallback(response) {
				defer.resolve(response.data);
			}, function errorCallback(err) {
				defer.reject(err);
			});
			return defer.promise;
		},

	}})
