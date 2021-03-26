<?php

namespace Delivery\Controller\Delivery;

use Delivery\Controller\LayoutController;
use Delivery\Domain\DeliveryDomain;
use Delivery\Model\DeliveryQuery;
use Delivery\Model\Map\DeliveryTableMap;
use Propel\Runtime\Propel;

class CancelController extends LayoutController
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

        /** @var DeliveryDomain $domain */
        $domain = $this->s('delivery.domain.delivery');

        $con = Propel::getConnection(DeliveryTableMap::DATABASE_NAME);
        $con->beginTransaction();

        try {
            $domain->cancel($obj);

            $con->commit();
        } catch (\Throwable $e) {
            $con->rollBack();

            throw $e;
        }
    }
}
