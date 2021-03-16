<?php

namespace Delivery\Module;

use Perfumer\Framework\Controller\Module;

class ControllerModule extends Module
{
    public $name = 'delivery';

    public $router = 'delivery.router';

    public $request = 'delivery.request';

    public $components = [
        'view' => 'view.status'
    ];
}