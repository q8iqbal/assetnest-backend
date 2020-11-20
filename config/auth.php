<?php

use App\Models\User;

return [
        'defaults' => [
            'guard' => 'api',
            'passwords' => 'users',
        ],

        'guards' => [
            'api' => [
                'driver' => 'jwt',
                'provider' => 'users',
            ],
        ],

        'providers' => [
            'users' => [
                'driver' => 'eloquent',
                'model' => User::class,
            ]
        ],

        'ttl' => env('JWT_TTL', null),
    ];
?>