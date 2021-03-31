<?php

namespace Delivery\Controller\Delivery;

use Delivery\Controller\LayoutController;
use Delivery\Facade\DeliveryFacade;
use Delivery\Model\Map\DeliveryTableMap;
use Propel\Runtime\Propel;

class SendController extends LayoutController
{
    public function post()
    {
        $id  = (int) $this->f('id');
        $min = (int) $this->f('_min');
        $max = (int) $this->f('_max');
        $gap = (int) $this->f('_gap');

        error_log(
            '[CUSTOM LOG] SendController.post(). Delivery_id => ' . $id . '; _min => ' . $min . '; _max => ' . $max
            . '; _gap => ' . $gap . PHP_EOL
        );

        /** @var DeliveryFacade $facade */
        $facade = $this->s('delivery.facade.delivery');

        $con = Propel::getConnection(DeliveryTableMap::DATABASE_NAME);
        $con->beginTransaction();

        try {
            $response = $facade->send($id, $min, $max, $gap);

            if (!$response->status) {
                $this->forward('error', 'badRequest', [$response->error]);
            }

            $con->commit();
        } catch (\Throwable $e) {
            $con->rollBack();

            throw $e;
        }
    }
}
