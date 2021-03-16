<?php

return [
    'propel' => [
        'database' => [
            'connections' => [
                'delivery' => [
                    'adapter' => 'pgsql',
                    'dsn' => 'pgsql:host=PG_HOST;port=PG_PORT;dbname=PG_DATABASE',
                    'user' => 'PG_USER',
                    'password' => 'PG_PASSWORD',
                    'settings' => [
                        'charset' => 'utf8',
                        'queries' => [
                            'utf8' => "SET NAMES 'UTF8'",
                            'schema' => "SET search_path TO PG_SCHEMA"
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
