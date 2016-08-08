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
<<<<<<< HEAD
		'../../../bower_components/jquery-bridget/jquery-bridget.js',
		'../../../bower_components/ev-emitter/ev-emitter.js',
		'../../../bower_components/desandro-matches-selector/matches-selector.js',
		'../../../bower_components/fizzy-ui-utils/utils.js',
		'../../../bower_components/get-size/get-size.js',
		'../../../bower_components/outlayer/item.js',
		'../../../bower_components/outlayer/outlayer.js',
		'../../../bower_components/masonry/masonry.js',
		'../../../bower_components/imagesloaded/imagesloaded.js',
		'../../../bower_components/angular/angular.js',
		'../../../bower_components/angular-masonry/angular-masonry.js',
		'../../../node_modules/js-cookie/src/js.cookie.js'
	], 'public/js/vendor.js');

	mix.scripts([
		'../../../bower_components/jQuery-ui-Slider-Pips/dist/jquery-ui-slider-pips.js',
	], 'public/js/slider.js');

	mix.copy('bower_components/jQuery-ui-Slider-Pips/dist/jquery-ui-slider-pips.css', 'public/css/jquery-ui-slider-pips.css');
=======
		'bower_components/jQuery-ui-Slider-Pips/dist/jquery-ui-slider-pips.js',
		'bower_components/js-cookie/src/js.cookie.js'
	], 'public/js/vendor.js');

	mix.scriptsIn('resources/assets/js/angular', 'public/js/angular.js');

>>>>>>> develop
	mix.copy('resources/assets/css/*', 'public/css');

	mix.stylus('app.styl', null, { use: [ bootstrap() ] });

<<<<<<< HEAD
	mix.browserSync({
=======
    mix.browserSync({
>>>>>>> develop
        proxy: 'xm.local',
        notify: true
    });
});
