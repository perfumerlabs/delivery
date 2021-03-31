<?php

return [
    'fast_router' => [
        'shared' => true,
        'init' => function(\Perfumer\Component\Container\Container $container) {
            return \FastRoute\simpleDispatcher(function(\FastRoute\RouteCollector $r) {
                $r->addRoute('POST', '/delivery', 'delivery.post');
                $r->addRoute('GET', '/delivery', 'delivery.get');
                $r->addRoute('PATCH', '/delivery', 'delivery.patch');
                $r->addRoute('DELETE', '/delivery', 'delivery.delete');
                $r->addRoute('GET', '/deliveries', 'deliveries.get');
                $r->addRoute('POST', '/delivery/send', 'delivery/send.post');
                $r->addRoute('POST', '/delivery/cancel', 'delivery/cancel.post');
                $r->addRoute('POST', '/delivery/copy', 'delivery/copy.post');
            });
        }
    ],

    'delivery.router' => [
        'shared' => true,
        'class' => 'Perfumer\\Framework\\Router\\Http\\FastRouteRouter',
        'arguments' => ['#gateway.http', '#fast_router', [
            'data_type' => 'json',
            'allowed_actions' => ['get', 'post', 'patch', 'delete'],
        ]]
    ],

    'delivery.request' => [
        'class' => 'Perfumer\\Framework\\Proxy\\Request',
        'arguments' => ['$0', '$1', '$2', '$3', [
            'prefix' => 'Delivery\\Controller',
            'suffix' => 'Controller'
        ]]
    ]
];
