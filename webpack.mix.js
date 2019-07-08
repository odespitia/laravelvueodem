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

mix.styles([
    'resources/plantillas/css/font-awesome.min.css',
    'resources/plantillas/css/simple-line-icons.min.css',
    'resources/plantillas/css/style.css'
], 'public/css/plantilla.css')
.scripts([
    'resources/plantillas/js/jquery.min.js',
    'resources/plantillas/js/popper.min.js',
    'resources/plantillas/js/bootstrap.min.js',
    'resources/plantillas/js/Chart.min.js',    
    'resources/plantillas/js/pace.min.js',    
    'resources/plantillas/js/template.js',
    'resources/plantillas/js/sweetalert2.all.min.js'
], 'public/js/plantilla.js')
.js([
    'resources/js/app.js'
], 'public/js/app.js');