<?php

namespace Delivery\Controller\Delivery;

use Delivery\Controller\LayoutController;
use Delivery\Facade\DeliveryFacade;
use Delivery\Model\DeliveryQuery;
use Delivery\Model\Map\DeliveryTableMap;
use Propel\Runtime\Propel;

class StartController extends LayoutController
{
    public function post()
    {
        $id = (int) $this->f('id');

        if (!$id) {
            $this->validateNotEmpty($id, 'id');
        }

        $obj = DeliveryQuery::create()
            ->findPk($id);

        if (!$obj) {
            $this->forward('error', 'badRequest', ["Рассылка не найдена"]);
        }

        /** @var DeliveryFacade $facade */
        $facade = $this->s('delivery.facade.delivery');

        $con = Propel::getConnection(DeliveryTableMap::DATABASE_NAME);
        $con->beginTransaction();

        try {
            $facade->start($obj);

            $con->commit();
        } catch (\Throwable $e) {
            $con->rollBack();

            throw $e;
        }
    }
}
