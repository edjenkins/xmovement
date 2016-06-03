var elixir = require('laravel-elixir');
var bootstrap = require('bootstrap-styl');
var stylus = require('laravel-elixir-stylus');

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
    mix.copy('resources/assets/css/*', 'public/css');
	mix.stylus('app.styl', null, { use: [ bootstrap() ] });
    mix.browserSync({
        proxy: 'xm.local',
        notify: false
    });
});
