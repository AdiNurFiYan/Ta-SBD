<?php

return [
    'defaults' => [
        'guard' => 'web',
        'passwords' => 'members',
    ],

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'members',
        ],
        'admin' => [
            'driver' => 'session',
            'provider' => 'admins',
        ],
        'member' => [
            'driver' => 'session',
            'provider' => 'members',
        ],
    ],

    'providers' => [
        'members' => [
            'driver' => 'eloquent',
            'model' => App\Models\Member::class,
        ],
        'admins' => [
            'driver' => 'eloquent',
            'model' => App\Models\Admin::class,
        ],
    ],

    'passwords' => [
        'members' => [
            'provider' => 'members',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
        'admins' => [
            'provider' => 'admins',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => 10800,
];