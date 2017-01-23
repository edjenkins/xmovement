XMovement.service('TeamService', function($http, $q) {
	return {
		'searchUsers': function(query) {
			var defer = $q.defer();
			$http.get('/api/team/user/search', { params: query }).then(function successCallback(response) {
				defer.resolve(response.data);
			}, function errorCallback(err) {
				defer.reject(err);
			});
			return defer.promise;
		},
		'addUser': function(body) {
			var defer = $q.defer();
			$http.post('/api/team/user/add', body).then(function successCallback(response) {
				defer.resolve(response.data);
			}, function errorCallback(err) {
				defer.reject(err);
			});
			return defer.promise;
		},
		'removeUser': function(body) {
			var defer = $q.defer();
			$http.post('/api/team/user/remove', body).then(function successCallback(response) {
				defer.resolve(response.data);
			}, function errorCallback(err) {
				defer.reject(err);
			});
			return defer.promise;
		},
		'getTeams': function(query) {
			var defer = $q.defer();
			$http.get('/api/teams', query).then(function successCallback(response) {
				defer.resolve(response.data);
			}, function errorCallback(err) {
				defer.reject(err);
			});
			return defer.promise;
		}
	}})
