<?php

namespace Delivery\Repository;

use Delivery\Model\Delivery;
use Delivery\Service\Timezone;

class DeliveryRepository
{
    private $timezone;

    private $notification_repository;

    public function __construct(Timezone $timezone, NotificationRepository $notification_repository)
    {
        $this->timezone                = $timezone;
        $this->notification_repository = $notification_repository;
    }

    public function format(?Delivery $obj): ?array
    {
        if (!$obj) {
            return null;
        }

        $created_at = $this->timezone->formatDate($obj->getCreatedAt());
        $updated_at = $this->timezone->formatDate($obj->getUpdatedAt());

        return [
            'name'         => $obj->getName(),
            'data_url'     => $obj->getDataUrl(),
            'filters'      => $obj->getFilters(),
            'status'       => $obj->getStatus(),
            'notification' => $this->notification_repository->format($obj->getNotification()),
            'created_at'   => $created_at ? $created_at->format('Y-m-d H:i:s') : null,
            'updated_at'   => $updated_at ? $updated_at->format('Y-m-d H:i:s') : null,
        ];
    }
}