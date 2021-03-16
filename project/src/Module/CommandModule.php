<?php

namespace Delivery\Module;

use Perfumer\Framework\Controller\Module;

class CommandModule extends Module
{
    public $name = 'delivery';

    public $router = 'router.console';

    public $request = 'delivery.request';
}