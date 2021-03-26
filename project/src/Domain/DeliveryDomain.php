<?php

namespace Delivery\Domain;

use Delivery\Model\Delivery;
use Delivery\Model\DeliveryQuery;
use Delivery\Model\Map\DeliveryTableMap;

class DeliveryDomain
{
    public function save(array $data): Delivery
    {
        $delivery = $data['delivery'] ?? null;

        $obj = null;

        if ($delivery instanceof Delivery) {
            $obj = $delivery;
        }

        if (!$obj) {
            $obj = new Delivery();
        }

        if (array_key_exists('name', $data)) {
            $obj->setName($data['name']);
        }

        if (array_key_exists('data_url', $data)) {
            $obj->setDataUrl($data['data_url']);
        }

        if (array_key_exists('filters', $data)) {
            $filters = $data['filters'];

            if ($filters !== null) {
                $filters = json_encode($filters);
            }

            $obj->setFilters($filters);
        }

        if (array_key_exists('status', $data)) {
            $obj->setStatus($data['status']);
        }

        $obj->save();

        return $obj;
    }

    public function cancel($obj): void
    {
        if (is_int($obj)) {
            $obj = DeliveryQuery::create()
                ->findPk((int) $obj);
        }

        if (!$obj instanceof Delivery) {
            return;
        }

        $obj->setStatus(DeliveryTableMap::COL_STATUS_CANCELED);

        $obj->save();
    }

    public function finish($obj): void
    {
        if (is_int($obj)) {
            $obj = DeliveryQuery::create()
                ->findPk((int) $obj);
        }

        if (!$obj instanceof Delivery) {
            return;
        }

        $obj->setStatus(DeliveryTableMap::COL_STATUS_FINISHED);

        $obj->save();
    }

    public function start($obj): void
    {
        if (is_int($obj)) {
            $obj = DeliveryQuery::create()
                ->findPk((int) $obj);
        }

        if (!$obj instanceof Delivery) {
            return;
        }

        $obj->setStatus(DeliveryTableMap::COL_STATUS_STARTED);

        $obj->save();
    }

    public function delete($obj): void
    {
        if (is_int($obj)) {
            $obj = DeliveryQuery::create()
                ->findPk((int) $obj);
        }

        if (!$obj instanceof Delivery) {
            return;
        }

        $obj->delete();
    }
}