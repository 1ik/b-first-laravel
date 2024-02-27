<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
    |
    */

    'default' => env('FILESYSTEM_DISK', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been set up for each driver as an example of the required values.
    |
    | Supported Drivers: "local", "ftp", "sftp", "s3"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
            'throw' => false,
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
            'throw' => false,
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_KEY', 'NOT_AVAILBLE'),
            'secret' => env('AWS_SECRET', 'NOT_AVAILBLE'),
            'region' => env('AWS_REGION', 'NOT_AVAILBLE'),
            'bucket' => env('AWS_BUCKET', 'NOT_AVAILBLE'),
            'url' => env('AWS_URL', 'https://s3.ap-south-1.amazonaws.com/bangladeshfirstphotos'),
            'acl' => 'public-read'
        ],

        'do_spaces' => [
            'driver' => 's3',
            'key' => env('DO_SPACES_KEY', 'NOT_AVAILBLE'),
            'secret' => env('DO_SPACES_SECRET', 'NOT_AVAILBLE'),
            'region' => env('DO_SPACES_REGION', 'NOT_AVAILBLE'),
            'bucket' => env('DO_SPACES_BUCKET', 'NOT_AVAILBLE'),
            'endpoint' => env('DO_SPACES_ENDPOINT', 'https://sgp1.digitaloceanspaces.com')
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    |
    | Here you may configure the symbolic links that will be created when the
    | `storage:link` Artisan command is executed. The array keys should be
    | the locations of the links and the values should be their targets.
    |
    */

    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],

];
