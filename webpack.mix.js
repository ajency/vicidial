let mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.babel([
	'resources/assets/js/bootstrap.min.js',
	'resources/assets/js/jquery.fancybox.js',
	'resources/assets/js/slick.min.js',
	'resources/assets/js/bootstrap-better-nav.min.js',
	'resources/assets/js/jquery.mousewheel.min.js',
	'resources/assets/js/lightgallery-all.min.js',
	'resources/assets/js/lazysizes.min.js',
	'resources/assets/js/bootstrap-select.min.js',
	'resources/assets/js/jquery.autocomplete.js',
	'resources/assets/js/custom.js'
	], 'public/js/all.js').version()
   .sass('resources/assets/scss/custom.scss', 'public/css')
   .options({
      processCssUrls: false
   })
   .styles([
   	'resources/assets/css/jquery.fancybox.css',
   	'resources/assets/css/bootstrap-better-nav.min.css',
   	'resources/assets/css/lightgallery.css',
   	'resources/assets/css/xzoom.css',
   	'resources/assets/css/bootstrap-select.min.css',
   	'public/css/custom.css'
   	], 'public/css/all.css').version()
   .copyDirectory('resources/assets/img', 'public/img')
   .copy('resources/assets/js/cart.js', 'public/js/cart.js');
