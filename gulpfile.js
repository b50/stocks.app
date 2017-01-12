var elixir = require('laravel-elixir');

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

elixir(function (mix) {

  // Define paths
  var bpath = 'node_modules/bootstrap-sass/assets';
  var fpath = 'node_modules/font-awesome';
  var jqueryPath = 'node_modules/jquery';

  // Generate the css. Copy the javascript and font files
  mix
    .sass('app.scss')
    .copy(jqueryPath + '/dist/jquery.min.js', 'public/js')
    .copy(fpath + '/fonts', 'public/fonts')
    .copy(bpath + '/fonts', 'public/fonts')
    .copy(bpath + '/javascripts/bootstrap.min.js', 'public/js');

// Compile ECMAScript 6 and 7 and JSX into plain JavaScript
  mix.babel("app.js");
  mix.babel("jquery.marquee.min.js");
});



