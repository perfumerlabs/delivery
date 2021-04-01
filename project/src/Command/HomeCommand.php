<?php

namespace Delivery\Command;

use Delivery\Service\Queue;
use Perfumer\Framework\Controller\PlainController;

class HomeCommand extends PlainController
{
    public function action()
    {
        /** @var Queue $queue */
        $queue = $this->s('queue');

        $queue->sendDelivery(5, 1, 23, 15);
    }
}
