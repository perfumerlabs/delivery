<?php

namespace Delivery\Response\Facade\DeliveryFacade;

use Delivery\Model\Delivery;

class SaveResponse
{
    /**
     * @var bool
     */
    public $status = true;

    /**
     * @var string
     */
    public $error;

    /**
     * @var Delivery
     */
    public $delivery;
}