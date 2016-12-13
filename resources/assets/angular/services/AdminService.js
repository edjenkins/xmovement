XMovement.service('AdminService', function($http, $q) {
	return {
		'updateConfig': function(body) {
			var defer = $q.defer();
			$http.post('/admin/config/update', body).success(function(resp){
				defer.resolve(resp);
			}).error( function(err) {
				defer.reject(err);
			});
			return defer.promise;
		},
		'fetchConfig': function(body) {
			var defer = $q.defer();
			$http.post('/admin/config/fetch', body).success(function(resp){
				defer.resolve(resp);
			}).error( function(err) {
				defer.reject(err);
			});
			return defer.promise;
		},
		'updatePermission': function(body) {
			var defer = $q.defer();
			$http.post('/admin/permissions/update', body).success(function(resp){
				defer.resolve(resp);
			}).error( function(err) {
				defer.reject(err);
			});
			return defer.promise;
		},
		'fetchPermission': function(body) {
			var defer = $q.defer();
			$http.post('/admin/permissions/fetch', body).success(function(resp){
				defer.resolve(resp);
			}).error( function(err) {
				defer.reject(err);
			});
			return defer.promise;
		},

	}})
