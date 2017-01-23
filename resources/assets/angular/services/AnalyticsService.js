XMovement.service('AnalyticsService', function($http, $q) {
	return {
		'getOverviewAnalytics': function() {
			var defer = $q.defer();
			$http.get('/api/analytics/overview').then(function successCallback(response) {
				defer.resolve(response.data);
			}, function errorCallback(err) {
				defer.reject(err);
			});
			return defer.promise;
		},
		'getUserAnalytics': function() {
			var defer = $q.defer();
			$http.get('/api/analytics/users').then(function successCallback(response) {
				defer.resolve(response.data);
			}, function errorCallback(err) {
				defer.reject(err);
			});
			return defer.promise;
		},
		'getIdeaAnalytics': function() {
			var defer = $q.defer();
			$http.get('/api/analytics/ideas').then(function successCallback(response) {
				defer.resolve(response.data);
			}, function errorCallback(err) {
				defer.reject(err);
			});
			return defer.promise;
		}
	}})
