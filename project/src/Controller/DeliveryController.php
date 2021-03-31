<?php

namespace Delivery\Controller;

use Delivery\Domain\DeliveryDomain;
use Delivery\Facade\DeliveryFacade;
use Delivery\Model\DeliveryQuery;
use Delivery\Model\Map\DeliveryTableMap;
use Delivery\Repository\DeliveryRepository;
use Propel\Runtime\Propel;

class DeliveryController extends LayoutController
{
    public function get()
    {
        $id = (int) $this->f('id');
        $locale = $this->f('locale');

        if (!$id) {
            $this->forward('error', 'badRequest', ["Нужно указать идентификатор рассылки"]);
        }

        $obj = null;

        if ($id) {
            $obj = DeliveryQuery::create()
                ->findPk($id);
        }

        if (!$obj) {
            $this->forward('error', 'badRequest', ["Рассылка не найдена"]);
        }

        /** @var DeliveryRepository $repository */
        $repository = $this->s('delivery.repository.delivery');

        $this->setContent(['delivery' => $repository->format($obj, true, $locale)]);
    }

    public function post()
    {
        /** @var DeliveryFacade $facade */
        $facade = $this->s('delivery.facade.delivery');

        $con = Propel::getConnection(DeliveryTableMap::DATABASE_NAME);
        $con->beginTransaction();

        try {
            $response = $facade->save($this->f());

            if (!$response->status) {
                $this->forward('error', 'badRequest', [$response->error]);
            }

            $con->commit();
        } catch (\Throwable $e) {
            $con->rollBack();

            throw $e;
        }
    }

    public function patch()
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
            $response = $facade->save($this->f(), $obj);

            if (!$response->status) {
                $this->forward('error', 'badRequest', [$response->error]);
            }

            $con->commit();
        } catch (\Throwable $e) {
            $con->rollBack();

            throw $e;
        }
    }

    public function delete()
    {
        $id = (int) $this->f('id');

        if (!$id) {
            $this->forward('error', 'badRequest', ["Укажите ID рассылки"]);
        }

        $obj = DeliveryQuery::create()->findPk($id);

        if (!$obj) {
            $this->forward('error', 'badRequest', ["Рассылка не найдена"]);
        }

        /** @var DeliveryDomain $domain */
        $domain = $this->s('delivery.domain.delivery');

        $con = Propel::getConnection(DeliveryTableMap::DATABASE_NAME);
        $con->beginTransaction();

        try {
            $domain->delete($obj);

            $con->commit();
        } catch (\Throwable $e) {
            $con->rollBack();

            throw $e;
        }
    }
}
