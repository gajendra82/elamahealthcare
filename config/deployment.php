<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Deployment Mode
    |--------------------------------------------------------------------------
    |
    | hostinger — shared hosting without symlinks or shell functions
    | local     — standard Laravel development
    |
    */

    'mode' => env('DEPLOYMENT_MODE', 'hostinger'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Paths
    |--------------------------------------------------------------------------
    */

    'laravel_root' => env('LARAVEL_ROOT', base_path()),

    'public_html' => env(
        'PUBLIC_HTML_PATH',
        dirname(base_path(), 2).DIRECTORY_SEPARATOR.'public_html'
    ),

    'laravel_relative_from_public_html' => env(
        'LARAVEL_RELATIVE_FROM_PUBLIC_HTML',
        '../laravel/elamahealthcare'
    ),

    'public_html_relative_from_laravel' => env(
        'PUBLIC_HTML_RELATIVE_FROM_LARAVEL',
        '../../public_html'
    ),

    /*
    |--------------------------------------------------------------------------
    | Asset Paths
    |--------------------------------------------------------------------------
    */

    'static_images' => 'images',

    'uploads' => 'uploads',

    /*
    |--------------------------------------------------------------------------
    | Hostinger Templates
    |--------------------------------------------------------------------------
    */

    'templates' => [
        'index' => base_path('deployment/hostinger/index.php'),
        'htaccess' => base_path('deployment/hostinger/.htaccess'),
        'deploy' => base_path('deployment/hostinger/deploy.sh'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Hostinger PHP Restrictions
    |--------------------------------------------------------------------------
    */

    'disabled_functions' => [
        'exec',
        'shell_exec',
        'system',
        'symlink',
        'link',
    ],

    /*
    |--------------------------------------------------------------------------
    | Deployment Requirements
    |--------------------------------------------------------------------------
    */

    'php_version' => '8.2.0',

    'required_extensions' => [
        'pdo',
        'mbstring',
        'openssl',
        'tokenizer',
        'xml',
        'ctype',
        'json',
        'fileinfo',
    ],

    'writable_paths' => [
        'storage',
        'storage/app',
        'storage/framework',
        'storage/framework/cache',
        'storage/framework/sessions',
        'storage/framework/views',
        'storage/logs',
        'bootstrap/cache',
        'public/uploads',
    ],

];
