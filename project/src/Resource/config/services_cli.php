<?php

return [
    'delivery.request' => [
        'class' => 'Perfumer\\Framework\\Proxy\\Request',
        'arguments' => ['$0', '$1', '$2', '$3', [
            'prefix' => 'Delivery\\Command',
            'suffix' => 'Command'
        ]]
    ]
];
