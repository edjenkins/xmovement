XMovement.service('CategoryService', function($http, $q) {
	return {
		'getIdeaCategories': function(query) {
			var defer = $q.defer();
			$http.get('/api/categories/idea').then(function successCallback(response) {
				defer.resolve(response.data);
			}, function errorCallback(err) {
				defer.reject(err);
			});
			return defer.promise;
		},
		'addIdeaCategory': function(body) {
			var defer = $q.defer();
			$http.post('/api/categories/idea/add', body).then(function successCallback(response) {
				defer.resolve(response.data);
			}, function errorCallback(err) {
				defer.reject(err);
			});
			return defer.promise;
		},
		'updateIdeaCategory': function(body) {
			var defer = $q.defer();
			$http.post('/api/categories/idea/update', body).then(function successCallback(response) {
				defer.resolve(response.data);
			}, function errorCallback(err) {
				defer.reject(err);
			});
			return defer.promise;
		},
		'deleteIdeaCategory': function(body) {
			var defer = $q.defer();
			$http.post('/api/categories/idea/delete', body).then(function successCallback(response) {
				defer.resolve(response.data);
			}, function errorCallback(err) {
				defer.reject(err);
			});
			return defer.promise;
		}
	}})
