var elixir = require('laravel-elixir');
var bootstrap = require('bootstrap-styl');
var stylus = require('laravel-elixir-stylus');
var jscookie = require('js-cookie');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {

	mix.scripts([
		'./bower_components/underscore/underscore.js',
		'./bower_components/moment/moment.js',
		'./bower_components/jQuery-ui-Slider-Pips/dist/jquery-ui-slider-pips.js',
		'./bower_components/js-cookie/src/js.cookie.js',
		'./resources/assets/vendor/bootstrap-daterangepicker/daterangepicker.js',
		'./resources/assets/vendor/easydropdown/jquery.easydropdown.js',
	], 'public/js/vendor.js');

	mix.styles([
		'./bower_components/jQuery-ui-Slider-Pips/dist/jquery-ui-slider-pips.css',
		'./resources/assets/vendor/bootstrap-daterangepicker/daterangepicker.css',
		'./resources/assets/vendor/easydropdown/easydropdown.css',
		'./resources/assets/vendor/dropzone/dropzone.css',
		'./bower_components/animate.css/animate.min.css'
	], 'public/css/vendor.css');

	mix.styles([
		'./resources/assets/vendor/dropzone/dropzone.css'
	], 'public/css/dropzone/dropzone.css');

	mix.scripts([
		'./bower_components/angular/angular.js',
		'./bower_components/angular-moment/angular-moment.js',
		'./bower_components/ev-emitter/ev-emitter.js',
		'./bower_components/imagesloaded/imagesloaded.js',
		'./bower_components/angular-images-loaded/angular-images-loaded.js',
		'./bower_components/isotope/jquery.isotope.js',
		'./bower_components/angular-isotope/dist/angular-isotope.min.js',
		'./bower_components/angular-route/angular-route.js',
		'./bower_components/ngstorage/ngStorage.js',
	], 'public/js/angular-dependencies.js');

	mix.scriptsIn('resources/assets/angular', 'public/js/angular.js');

	mix.copy('./resources/assets/vendor/*', 'public/js/vendor');

	mix.copy('resources/assets/css', 'public/css');
	mix.copy('resources/assets/js', 'public/js');

	mix.stylus('resources/assets/stylus/email.styl', 'public/css/email.css');

	mix.stylus('app.styl', null, { use: [ bootstrap() ] });

    mix.browserSync({
        proxy: 'xm.local',
        notify: false
    });
});
