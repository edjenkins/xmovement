XMovement.service('TeamService', function($http, $q) {
	return {
		'searchUsers': function(query) {
			var defer = $q.defer();
			$http.get('/api/team/user/search', { params: query }).success(function(resp){
				defer.resolve(resp);
			}).error( function(err) {
				defer.reject(err);
			});
			return defer.promise;
		},
		'addUser': function(body) {
			var defer = $q.defer();
			$http.post('/api/team/user/add', body).success(function(resp){
				defer.resolve(resp);
			}).error( function(err) {
				defer.reject(err);
			});
			return defer.promise;
		},
		'getTeams': function(query) {
			var defer = $q.defer();
			$http.get('/api/teams', query).success(function(resp){
				defer.resolve(resp);
			}).error( function(err) {
				defer.reject(err);
			});
			return defer.promise;
		}
	}})
