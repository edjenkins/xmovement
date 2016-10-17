XMovement.service('UpdateService', function($http, $q) {
	return {
		'postUpdate': function(body) {

			$('meta[name="csrf-token"]').attr('content')

			var req = {
				method: 'POST',
				url: '/api/update/add',
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
		        	'Content-type': 'application/json'
				},
				data: body
			};

			var defer = $q.defer();
			
			$http(req).success(function(resp){
				defer.resolve(resp);
			}).error( function(err) {
				defer.reject(err);
			});
			return defer.promise;
		}
	}})
