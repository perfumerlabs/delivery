<?php

namespace Delivery\Controller;

use Delivery\Model\DeliveryQuery;
use Delivery\Repository\DeliveryRepository;

class NotificationController extends LayoutController
{
    public function get()
    {
        $id     = (int) $this->f('id');
        $locale = $this->f('locale');

        if (!$id) {
            $this->forward('error', 'badRequest', ["Нужно указать идентификатор рассылки"]);
        }

        $obj = null;

        if ($id) {
            $obj = DeliveryQuery::create()
                ->joinWithNotification()
                ->findPk($id);
        }

        if (!$obj) {
            $this->forward('error', 'badRequest', ["Рассылка не найдена"]);
        }

        /** @var DeliveryRepository $repository */
        $repository = $this->s('delivery.repository.delivery');

        $this->setContent(['notification' => $repository->formatNotification($obj, $locale)]);
    }
}
