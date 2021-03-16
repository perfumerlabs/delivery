<?php

namespace Project;

use Perfumer\Framework\Gateway\CompositeGateway;

class Gateway extends CompositeGateway
{
    protected function configure(): void
    {
        $this->addModule('delivery', null,       null, 'http');
        $this->addModule('delivery', 'delivery', null, 'cli');
    }
}
