XMovement.service('UserService', function($http, $q) {
	return {
		'searchUsers': function(query) {
			var defer = $q.defer();
			$http.get('/api/user/search', { params: query }).then(function successCallback(response) {
				defer.resolve(response.data);
			}, function errorCallback(err) {
				defer.reject(err);
			});
			return defer.promise;
		},
		'getAdmins': function() {
			var defer = $q.defer();
			$http.get('/api/user/admins').then(function successCallback(response) {
				defer.resolve(response.data);
			}, function errorCallback(err) {
				defer.reject(err);
			});
			return defer.promise;
		}
	}})
