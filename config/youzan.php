<?php

return [
    'default_app' => 'default',
    'base' => [
        'debug' => false,
        'log' => [
            'name' => 'youzan',
            'file' => storage_path('logs/youzan.log'),
            'level' => 'debug',
            'permission' => 0777
        ]
    ],
    'apps' => [
        'default' => [
            'client_id' => env('YOUZAN_CLIENT_ID'),
            'client_secret' => env('YOUZAN_CLIENT_SECRET'),
            'kdt_id' => env('YOUZAN_STORE_ID')
        ]
    ]
];
