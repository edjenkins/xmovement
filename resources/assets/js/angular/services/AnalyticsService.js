XMovement.service('AnalyticsService', function($http, $q) {
	return {
		'getOverviewAnalytics': function() {
			var defer = $q.defer();
			$http.get('/api/analytics/overview').success(function(resp){
				defer.resolve(resp);
			}).error( function(err) {
				defer.reject(err);
			});
			return defer.promise;
		},
		'getUserAnalytics': function() {
			var defer = $q.defer();
			$http.get('/api/analytics/users').success(function(resp){
				defer.resolve(resp);
			}).error( function(err) {
				defer.reject(err);
			});
			return defer.promise;
		},
		'getIdeaAnalytics': function() {
			var defer = $q.defer();
			$http.get('/api/analytics/ideas').success(function(resp){
				defer.resolve(resp);
			}).error( function(err) {
				defer.reject(err);
			});
			return defer.promise;
		}
	}})
