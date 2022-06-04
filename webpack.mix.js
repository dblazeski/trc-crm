const mix = require('laravel-mix');
require('mix-tailwindcss');

mix
    .js('resources/js/app.js', 'public/js')
    .vue({ version: 2 });

mix
    .postCss('resources/css/app.css', 'public/css', [
        require("tailwindcss")
    ]);

mix.disableSuccessNotifications();
