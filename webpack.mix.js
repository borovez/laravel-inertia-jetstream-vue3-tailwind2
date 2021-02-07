const mix = require("laravel-mix");
const path = require("path");

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.vue({ version: 3 })
    .js("resources/js/app.js", "public/js")
    .vue()
    .sass("resources/sass/app.scss", "public/css")
    .options({
        processCssUrls: false,
        postCss: [
            require("postcss-import"),
            require("tailwindcss"),
            require("autoprefixer"),
        ]
    })
    // .postCss('resources/css/app.css', 'public/css', [
    //     require('postcss-import'),
    //     require('tailwindcss'),
    //     require('autoprefixer'),
    // ])
    .webpackConfig(require("./webpack.config"));

if (mix.inProduction()) {
    mix.version();
}

// New Alias plugin
mix.alias({
    "@": path.resolve("resources/js"),
});
