XMovement.controller('TranslationController', function($scope, $http, $rootScope, $timeout, TranslationService) {

	$scope.translations = [];

	$scope.getTranslations = function() {

		console.log("Loading translations");

		$scope.translations = [];

		TranslationService.getTranslations({ override : false }).then(function(response) {

			console.log(response);

			$scope.translations = response.data.translations;

			setTimeout(function() { $('textarea').expanding(); }, 500);

		});
	}

	$scope.findTranslations = function($event) {

		console.log("Finding translations");

		$($event.target).html('Finding..');

		$timeout(function () {

			TranslationService.findTranslations().then(function(response) {

				console.log(response);

				$($event.target).html('Find');

				alert('Find complete');

			});

		}, 1000);
	}

	$scope.updateTranslation = function(translation) {

		console.log('Updating translation');

		translation.state = 'loading';

		translation.value = translation.original;

		TranslationService.updateTranslation({ translation : translation }).then(function(response) {

			translation.state = 'updated';

			console.log(response);

		});
	}

	$scope.importTranslations = function($event) {

		console.log("Importing translations");

		$($event.target).html('Importing..');

		$scope.translations = [];

		$timeout(function () {

			TranslationService.getTranslations({ override : true }).then(function(response) {

				console.log(response);

				$scope.translations = response.data.translations;

				setTimeout(function() { $('textarea').expanding(); }, 500);

				$($event.target).html('Import');

				alert('Import complete');

			});

		}, 1000);

	}

	$scope.exportAllTranslations = function($event) {

		console.log('Exporting all translations');

		$($event.target).html('Exporting..');

		$timeout(function () {

			TranslationService.exportAllTranslations().then(function(response) {

				console.log(response);

				$($event.target).html('Export');

				alert('Export complete');

			});

		}, 1000);

	}

	$scope.getTranslations();

});
