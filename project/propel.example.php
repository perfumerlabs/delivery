<?php

return [
    'propel' => [
        'database' => [
            'connections' => [
                'delivery' => [
                    'adapter' => 'pgsql',
                    'dsn' => 'pgsql:host=db;port=5432;dbname=delivery',
                    'user' => 'postgres',
                    'password' => 'postgres',
                    'settings' => [
                        'charset' => 'utf8',
                        'queries' => [
                            'utf8' => "SET NAMES 'UTF8'",
                            'schema' => "SET search_path TO public"
                        ]
                    ],
                    'attributes' => []
                ]
            ]
        ],
        'runtime' => [
            'defaultConnection' => 'delivery',
            'connections' => ['delivery']
        ],
        'generator' => [
            'defaultConnection' => 'delivery',
            'connections' => ['delivery']
        ]
    ]
];
