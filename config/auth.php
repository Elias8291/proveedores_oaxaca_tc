<?php

return [
    'defaults' => [
        'guard' => 'web',
        'passwords' => 'users',
    ],

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],
        
        // Opcional: puedes agregar un guard para API si lo necesitas
        'api' => [
            'driver' => 'passport', // o 'sanctum' si usas Sanctum
            'provider' => 'users',
            'hash' => false,
        ],
    ],

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],
        
        // Opcional: provider para autenticación por RFC específico
        'rfc_users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
            'auth_field' => 'rfc', // Campo personalizado para autenticación
        ],
    ],

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => 10800,
];