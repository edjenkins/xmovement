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
		'bower_components/jQuery-ui-Slider-Pips/dist/jquery-ui-slider-pips.js',
		'bower_components/js-cookie/src/js.cookie.js'
	], 'public/js/vendor.js');

	mix.scriptsIn('resources/assets/js/angular', 'public/js/angular.js');

	mix.copy('resources/assets/css/*', 'public/css');

	mix.copy('resources/assets/js/bower_components/jQuery-ui-Slider-Pips/dist/jquery-ui-slider-pips.css', 'public/css/jquery-ui-slider-pips.css');

	mix.stylus('app.styl', null, { use: [ bootstrap() ] });

    mix.browserSync({
        proxy: 'xm.local',
        notify: true
    });
});
