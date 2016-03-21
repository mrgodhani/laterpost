var elixir = require('laravel-elixir');

require('laravel-elixir-vueify');
require('laravel-elixir-imagemin');

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
    mix.sass('app.scss');
    mix.imagemin();
    mix.browserify('app.js');
    mix.scripts(['vendors/bootstrap.js','vendors/jquery.datetimepicker.min.js'],'public/js/lib.js');
    mix.version(['css/app.css', 'js/app.js','js/lib.js']);
    mix.copy('node_modules/bootstrap-sass/assets/fonts/', 'public/build/fonts/');
});
