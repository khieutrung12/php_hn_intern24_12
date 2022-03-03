const mix = require("laravel-mix");

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

mix.js("resources/js/app.js", "public/js").postCss(
    "resources/css/app.css",
    "public/css",
    [
        require("postcss-import"),
        require("tailwindcss"),
        require("postcss-nested"),
        require("autoprefixer"),
    ]
);

if (mix.inProduction()) {
    mix.version();
}
mix.sass("resources/css/style-app-user.scss", "css/style-app-user.css");
mix.postCss(
    "resources/css/style-responsive.css",
    "css/style-responsive.css"
).options({
    processCssUrls: false,
});
mix.postCss("resources/css/style.css", "css/style.css").options({
    processCssUrls: false,
});
mix.postCss(
    "resources/css/style-tailwind.css",
    "css/style-tailwind.css"
).options({
    processCssUrls: false,
});
mix.postCss("resources/css/style-custom.css", "css/style-custom.css").options({
    processCssUrls: false,
});

mix.js("resources/js/jquery.dcjqaccordion.2.7.js", "public/js")
    .js("resources/js/jquery.nicescroll.js", "public/js")
    .js("resources/js/scripts.js", "public/js")
    .copy("resources/js/cart_update.js", "public/js/cart_update.js")
    .copy("resources/js/style.js", "public/js/style.js");
