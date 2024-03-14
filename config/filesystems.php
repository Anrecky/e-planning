<?php

use App\Supports\Disk;

return [
    'default' => env('FILESYSTEM_DISK', 'local'),
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
        Disk::ActivityRecapAttachment => [
            'driver' => 'scoped',
            'disk' => 'local',
            'prefix' => 'activity/attachments-recap',
        ],

    ],
    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],

];
