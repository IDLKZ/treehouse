const mix = require('laravel-mix');

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

// mix.js('resources/js/app.js', 'public/js')
//     .sass('resources/sass/app.scss', 'public/css')
//     .sourceMaps();

mix.styles([
    'resources/assets/css/font-awesome.min.css',
    'resources/assets/css/bootstrap.min.css',
    'resources/assets/css/slicknav.min.css',
    'resources/assets/css/owl.carousel.css',
    'resources/assets/css/icofont.css',
    'resources/assets/css/magnific-popup.css',
    'resources/assets/css/timeline.css',
    'resources/assets/css/lightbox.min.css',
    'resources/assets/css/style.css',
    'resources/assets/css/responsive.css'
], 'public/css/front.css')

mix.scripts([
    'resources/assets/js/jquery.min.js',
    'resources/assets/js/popper.min.js',
    'resources/assets/js/bootstrap.min.js',
    'resources/assets/js/owl.carousel.min.js',
    'resources/assets/js/jquery.slicknav.min.js',
    'resources/assets/js/jquery.circlechart.js',
    'resources/assets/js/timeline.js',
    'resources/assets/js/jquery.magnific-popup.min.js',
    'resources/assets/js/lightbox.min.js',
    'resources/assets/js/jquery.imagezoom.js',
    'resources/assets/js/main.js',
], 'public/js/front.js')

mix.copy('resources/assets/fonts', 'public/fonts')
mix.copy('resources/assets/img', 'public/images/front')
