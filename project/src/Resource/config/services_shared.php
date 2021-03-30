<?php

return [
    'gateway' => [
        'shared'    => true,
        'class'     => 'Project\\Gateway',
        'arguments' => ['#application', '#gateway.http', '#gateway.console'],
    ],

    'queue' => [
        'shared'    => true,
        'class'     => 'Delivery\\Service\\Queue',
        'arguments' => [
            '@delivery/queue_url',
            '@delivery/sms_url',
            '@delivery/email_url',
            '@delivery/feed_url',
            '@delivery/url',
            '@delivery/sms_worker',
            '@delivery/email_worker',
            '@delivery/feed_worker',
            '@delivery/fraction_worker',
        ],
    ],

    'propel.connection_manager' => [
        'class' => 'Propel\\Runtime\\Connection\\ConnectionManagerSingle',
        'after' => function (
            \Perfumer\Component\Container\Container $container,
            \Propel\Runtime\Connection\ConnectionManagerSingle $connection_manager
        ) {
            $configuration = [
                'dsn'      => $container->getParam('propel/dsn'),
                'user'     => $container->getParam('propel/db_user'),
                'password' => $container->getParam('propel/db_password'),
                'settings' => [
                    'charset' => 'utf8',
                ],
            ];

            $schema = $container->getParam('propel/db_schema');

            if ($schema !== 'public' && $schema !== null) {
                $configuration['settings']['queries'] = [
                    'schema' => "SET search_path TO " . $schema,
                ];
            }

            $connection_manager->setConfiguration($configuration);
        },
    ],

    'timezone' => [
        'shared'    => true,
        'class'     => 'Delivery\\Service\Timezone',
        'arguments' => ['@delivery/timezone'],
    ],

    'delivery.domain.delivery' => [
        'shared' => true,
        'class'  => 'Delivery\\Domain\\DeliveryDomain',
    ],

    'delivery.repository.delivery' => [
        'shared'    => true,
        'class'     => 'Delivery\\Repository\\DeliveryRepository',
        'arguments' => [
            '#timezone',
        ],
    ],

    'delivery.facade.delivery' => [
        'shared'    => true,
        'class'     => 'Delivery\\Facade\\DeliveryFacade',
        'arguments' => [
            '#queue',
            '#delivery.domain.delivery',
        ],
    ],
];