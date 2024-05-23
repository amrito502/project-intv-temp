const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
mix.js('resources/js/front_app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .sass('resources/sass/front_app.scss', 'public/css')
    .sourceMaps();
