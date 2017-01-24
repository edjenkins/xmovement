XMovement.service('TranslationService', function($http, $q) {
	return {
		'getTranslations': function(params) {
			var defer = $q.defer();
			$http({
			    url: '/api/translations',
			    method: "GET",
			    params: params
			 }).then(function successCallback(response) {
				defer.resolve(response.data);
			}, function errorCallback(err) {
				defer.reject(err);
			});
			return defer.promise;
		},
		'findTranslations': function(params) {
			var defer = $q.defer();
			$http({
			    url: '/api/translations/find',
			    method: "GET",
			    params: params
			 }).then(function successCallback(response) {
				defer.resolve(response.data);
			}, function errorCallback(err) {
				defer.reject(err);
			});
			return defer.promise;
		},
		'updateTranslation': function(body) {
			var defer = $q.defer();
			$http.post('/api/translation/update', body).then(function successCallback(response) {
				defer.resolve(response.data);
			}, function errorCallback(err) {
				defer.reject(err);
			});
			return defer.promise;
		},
		'exportAllTranslations': function() {
			var defer = $q.defer();
			$http.get('/api/translations/export').then(function successCallback(response) {
				defer.resolve(response.data);
			}, function errorCallback(err) {
				defer.reject(err);
			});
			return defer.promise;
		}

	}})
