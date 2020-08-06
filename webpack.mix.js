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

 /*
 * Frontend
 */

//Customisation files
mix.babel('resources/js/frontend.js', 'public/assets/js/custom-es5-frontend.js')
   .sass('resources/sass/frontend.scss', 'public/assets/css');

//mix frontend style liberaries into bundle
mix.styles([
    'public/assets/css/bootstrap.min.css',
], 'public/assets/css/libs.css' );

//mix frontend js liberaries into bundle
mix.scripts([
    'public/assets/js/jquery-2.1.0.min.js',
    'public/assets/js/global.js',
], 'public/assets/js/libs.js' );

/*
* Backend 
*/

mix.babel('resources/js/admin.js', 'public/administrator/assets/js/custom-es5-backend.js')
   .sass('resources/sass/admin/admin.scss', 'public/administrator/assets/css');

//mix backend style liberaries into bundle
mix.styles([
    'public/administrator/assets/vendor/bootstrap/css/bootstrap.min.css',
    'public/administrator/assets/vendor/fonts/circular-std/style.css',
    'public/administrator/assets/vendor/fonts/fontawesome/css/fontawesome-all.css',
    'public/administrator/assets/vendor/fonts/material-design-iconic-font/css/materialdesignicons.min.css',
    'public/administrator/assets/vendor/fonts/flag-icon-css/flag-icon.min.css'
], 'public/administrator/assets/css/libs.css' );

//mix backend scrips into one
mix.scripts([
   'public/administrator/assets/vendor/jquery/jquery-3.3.1.min.js',
   'public/administrator/assets/vendor/datatables/js/jquery.dataTables.min.js',
   'public/administrator/assets/vendor/datatables/js/dataTables.bootstrap4.min.js',
   'public/administrator/assets/vendor/datatables/js/data-table.js',
   'public/administrator/assets/vendor/bootstrap/js/bootstrap.bundle.js',
   'public/administrator/assets/vendor/slimscroll/jquery.slimscroll.js',
   'public/administrator/assets/vendor/axios/axios.min.js',
   'public/administrator/assets/libs/js/main-js.js',
], 'public/administrator/assets/js/libs.js' );
