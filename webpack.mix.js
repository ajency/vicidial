let mix = require('laravel-mix');
require('dotenv').config();

let proxy_url = process.env.APP_URL ;

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
	'resources/assets/js/plugins/bootstrap.min.js',
	'resources/assets/js/plugins/jquery.fancybox.js',
  'resources/assets/js/plugins/slick.min.js',
	'resources/assets/js/plugins/flickity.pkgd.min.js',
	'resources/assets/js/plugins/stellarnav.min.js',
	'resources/assets/js/plugins/jquery.mousewheel.min.js',
	'resources/assets/js/plugins/lightgallery-all.min.js',
	'resources/assets/js/plugins/lazysizes.min.js',
	'resources/assets/js/plugins/bootstrap-select.min.js',
	'resources/assets/js/plugins/jquery.autocomplete.js',
   'resources/assets/js/plugins/ion.rangeSlider.min.js',
	'resources/assets/js/custom.js'
	], 'public/js/all.js')
   .sass('resources/assets/scss/custom.scss', '../resources/assets/css')
   .options({
      processCssUrls: false
   })
   .styles([
   	'resources/assets/css/plugins/*.css',
   	'resources/assets/css/custom.css'
   	], 'public/css/all.css')
   .copyDirectory('resources/assets/img', 'public/img')
   .copyDirectory('resources/assets/fonts', 'public/fonts')
   .babel('resources/assets/js/cart.js', 'public/js/cart.js')
   .babel('resources/assets/js/productlisting.js', 'public/js/productlisting.js')
   .babel('resources/assets/js/singleproduct.js', 'public/js/singleproduct.js')
   .browserSync({
        proxy: proxy_url,
    });

if (mix.inProduction()) {
   mix.version();
}