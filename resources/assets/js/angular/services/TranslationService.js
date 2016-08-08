XMovement.service('TranslationService', function($http, $q) {
	return {
		'getTranslations': function(params) {
			var defer = $q.defer();
			$http({
			    url: '/api/translations',
			    method: "GET",
			    params: params
			 }).success(function(resp){
				defer.resolve(resp);
			}).error( function(err) {
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
			 }).success(function(resp){
				defer.resolve(resp);
			}).error( function(err) {
				defer.reject(err);
			});
			return defer.promise;
		},
		'updateTranslation': function(body) {
			var defer = $q.defer();
			$http.post('/api/translation/update', body).success(function(resp){
				defer.resolve(resp);
			}).error( function(err) {
				defer.reject(err);
			});
			return defer.promise;
		},
		'exportAllTranslations': function() {
			var defer = $q.defer();
			$http.get('/api/translations/export').success(function(resp){
				defer.resolve(resp);
			}).error( function(err) {
				defer.reject(err);
			});
			return defer.promise;
		}

	}})
