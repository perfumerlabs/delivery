<?php

namespace Delivery\Domain;

use Delivery\Model\Delivery;
use Delivery\Model\DeliveryQuery;
use Delivery\Model\Map\DeliveryTableMap;
use Propel\Runtime\Propel;

class DeliveryDomain
{
    public function save(array $data, Delivery $delivery = null): Delivery
    {
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

        if (array_key_exists('has_email', $data)) {
            $obj->setHasEmail((bool) $data['has_email']);
        }

        if (array_key_exists('has_feed', $data)) {
            $obj->setHasFeed((bool) $data['has_feed']);
        }

        if (array_key_exists('has_sms', $data)) {
            $obj->setHasSms((bool) $data['has_sms']);
        }

        if (array_key_exists('status', $data)) {
            $obj->setStatus($data['status']);
        }

        if (array_key_exists('nb_all_notifications', $data)) {
            $obj->setNbAllNotifications($data['nb_all_notifications']);
        }

        if (array_key_exists('data_url', $data)) {
            $obj->setDataUrl($data['data_url']);
        }

        if (array_key_exists('filters', $data)) {
            $obj->setFilters($data['filters']);
        }

        if (array_key_exists('feed_payload', $data)) {
            $obj->setFeedPayload($data['feed_payload']);
        }

        if (array_key_exists('payload', $data)) {
            $obj->setPayload($data['payload']);
        }

        if (array_key_exists('email_subject', $data)) {
            $this->setEmailSubject($obj, $data['email_subject']);
        }

        if (array_key_exists('email_html', $data)) {
            $this->setEmailHtml($obj, $data['email_html']);
        }

        if (array_key_exists('sms_message', $data)) {
            $this->setSmsMessage($obj, $data['sms_message']);
        }

        if (array_key_exists('feed_title', $data)) {
            $this->setFeedTitle($obj, $data['feed_title']);
        }

        if (array_key_exists('feed_text', $data)) {
            $this->setFeedText($obj, $data['feed_text']);
        }

        if (array_key_exists('feed_image', $data)) {
            $this->setFeedImage($obj, $data['feed_image']);
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

    public function copy($obj): void
    {
        if (is_int($obj)) {
            $obj = DeliveryQuery::create()
                ->findPk((int) $obj);
        }

        if (!$obj instanceof Delivery) {
            return;
        }

        $copy_obj = $obj->copy();

        $copy_obj->setNbSentNotifications(0);
        $copy_obj->setStatus(DeliveryTableMap::COL_STATUS_WAITING);
        $copy_obj->setCreatedAt(new \DateTime());
        $copy_obj->setUpdatedAt(new \DateTime());

        $copy_obj->save();

        $copy_notif = $obj->getNotification()->copy();
        $copy_notif->setDelivery($copy_obj);
        $copy_notif->save();

        foreach ($obj->getNotification()->getNotificationI18ns() as $notif_i18n) {
            $copy_notif_i18n = $notif_i18n->copy();
            $copy_notif_i18n->setNotification($copy_notif);
            $copy_notif_i18n->save();
        }
    }

    public function increaseSentNotifications(Delivery $obj, int $count): void
    {
        $con = Propel::getWriteConnection(DeliveryTableMap::DATABASE_NAME);

        $query = 'UPDATE delivery_delivery SET nb_sent_notifications = nb_sent_notifications + ' . $count . ' WHERE id = ' . $obj->getId() . ';';

        $stmt = $con->prepare($query);
        $stmt->execute();
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

    private function setEmailSubject(Delivery $obj, $value): void
    {
        if (!$value) {
            return;
        }

        foreach ($value as $k => $v) {
            if (!$v) {
                continue;
            }

            $obj->setLocale($k);
            $obj->setEmailSubject($v);
        }
    }

    private function setEmailHtml(Delivery $obj, $value): void
    {
        if (!$value) {
            return;
        }

        foreach ($value as $k => $v) {
            if (!$v) {
                continue;
            }

            $obj->setLocale($k);
            $obj->setEmailHtml($v);
        }
    }

    private function setSmsMessage(Delivery $obj, $value): void
    {
        if (!$value) {
            return;
        }

        foreach ($value as $k => $v) {
            if (!$v) {
                continue;
            }

            $obj->setLocale($k);
            $obj->setSmsMessage($v);
        }
    }

    private function setFeedTitle(Delivery $obj, $value): void
    {
        if (!$value) {
            return;
        }

        foreach ($value as $k => $v) {
            if (!$v) {
                continue;
            }

            $obj->setLocale($k);
            $obj->setFeedTitle($v);
        }
    }

    private function setFeedText(Delivery $obj, $value): void
    {
        if (!$value) {
            return;
        }

        foreach ($value as $k => $v) {
            if (!$v) {
                continue;
            }

            $obj->setLocale($k);
            $obj->setFeedText($v);
        }
    }

    private function setFeedImage(Delivery $obj, $value): void
    {
        if (!$value) {
            return;
        }

        foreach ($value as $k => $v) {
            if (!$v) {
                continue;
            }

            $obj->setLocale($k);
            $obj->setFeedImage($v);
        }
    }
}