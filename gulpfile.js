var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    mix.sass('app.scss', 'resources/assets/css');
    
    mix.styles([
        'libs/font-awesome.min.css',
        'libs/fontsgoogleapi.css',
        'libs/bootstrap.min.css',
        'app.css',
        'libs/bootstrap-datetimepicker.min.css',
        'libs/fullcalendar.css'
    ]);
    
    mix.scripts([
        'libs/jquery.min.js',
        'libs/jquery-ui.min.js',
        'libs/moment.min.js',
        'libs/fullcalendar.min.js',
        'libs/lang-all.js',
        'libs/bootstrap.min.js',
        'libs/bootstrap-datetimepicker.min.js',
        'configs/datepicker.js'

    ]);
});
