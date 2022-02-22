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

mix
    .js('resources/js/app.js', 'public/js')
    .postCss('resources/css/app.css', 'public/css', [
        require('postcss-import'),
        require('tailwindcss'),
        require('postcss-nested'),
        require('autoprefixer'),
    ]);

if (mix.inProduction()) {
    mix.version();
}
mix.postCss('resources/css/font-awesome.css','css/font-awesome.css').options({
    processCssUrls: false
     });
mix.postCss('resources/css/style-responsive.css','css/style-responsive.css').options({
    processCssUrls: false
     });
mix.postCss('resources/css/style.css','css/style.css').options({
    processCssUrls: false
     });
mix.postCss('resources/css/bootstrap.min.css','css/bootstrap.min.css').options({
    processCssUrls: false
    });
     
mix.js('resources/js/bootstrap.js', 'public/js')
.js('resources/js/jquery.dcjqaccordion.2.7.js', 'public/js')
.js('resources/js/jquery.nicescroll.js', 'public/js')
.js('resources/js/jquery2.0.3.min.js', 'public/js')
.js('resources/js/scripts.js', 'public/js')
