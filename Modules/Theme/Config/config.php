<?php

return [
    'name' => 'Themes',
    'themeDir' => 'Themes',
    /*
    |--------------------------------------------------------------------------
    | Default active Theme
    |--------------------------------------------------------------------------
    |
    | Default active themename. like as
    | 'active' => 'themeone',
    |
    */
    'active'     => '',

    /*
    |--------------------------------------------------------------------------
    | Themes path
    |--------------------------------------------------------------------------
    |
    | This path used for save the generated theme. This path also will added
    | automatically to list of scanned folders.
    |
    */
    'theme_path' => base_path('Themes'),

    /*
    |--------------------------------------------------------------------------
    | Symbolic link
    |--------------------------------------------------------------------------
    |
    | If you theme_path is not in public folder then symlink must be true
    | otherwise theme assets not working. If your theme_path under public folder
    | then symlink can be false or true as your wish.
    |
    */
    'symlink'    => true,

    /*
    |--------------------------------------------------------------------------
    | Theme types where you can set default theme for particular middleware.
    |--------------------------------------------------------------------------
    | 'types'     => [
    |       'enable' => true or false,
    |       'middleware' => [
    |           'middlewareName'      => 'themeName',
    |       ]
    |   ],
    |
    | For Example route
    | Route::get('/', function () {
    |       return view('welcome');
    | })->middleware('example');
    |
    |
    */
    'types'     => [
        'enable'        => false,
        'middleware'    => [
            'example'      => 'admin',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Theme config name and change log file name
    |--------------------------------------------------------------------------
    |
    | Here is the config for theme.json file and changelog
    | for version control status
    |
    */
    'config'     => [
        'name'      => 'theme.json',
        'changelog' => 'changelog.yml',
    ],

    /*
    |--------------------------------------------------------------------------
    | Themes folder structure
    |--------------------------------------------------------------------------
    |
    | Here you may update theme folder structure.
    |
    */
    'folders'    => [
        'assets'  => 'assets',
        'views'   => 'views',
        'lang'    => 'lang',
        'lang/en' => 'lang/en',

        'css' => 'assets/css',
        'js'  => 'assets/js',
        'img' => 'assets/img',

        'layouts' => 'views/layouts',
        'controller' => 'src/Http/Controllers',
        'functions' => 'functions',
        'routes' => 'routes'
    ],

    /*
    |--------------------------------------------------------------------------
    | Theme Stubs
    |--------------------------------------------------------------------------
    |
    | Default theme stubs.
    |
    */
    'stubs'      => [
        'path'  => base_path('stubs/themes'),
        'files' => [
            'css'    => 'assets/css/app.css',
            'layout' => 'views/layouts/master.blade.php',
            'page'   => 'views/welcome.blade.php',
            'lang'   => 'lang/en/content.php',
            'functions'   => 'functions/functions.php',
            'web'   => 'routes/web.php',
            'controller'   => 'Controller.php',
        ],
    ],
];
