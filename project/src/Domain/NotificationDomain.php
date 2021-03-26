<?php

namespace Delivery\Domain;

use Delivery\Model\DeliveryQuery;
use Delivery\Model\Notification;
use Delivery\Model\NotificationQuery;

class NotificationDomain
{
    public function save(array $data): Notification
    {
        $delivery = $data['delivery'] ?? null;

        if (is_int($delivery)) {
            $delivery = DeliveryQuery::create()
                ->findPk($delivery);
        }

        $obj = NotificationQuery::create()
            ->filterByDelivery($delivery)
            ->findOneOrCreate();

        if (array_key_exists('has_email', $data)) {
            $obj->setHasEmail((bool) $data['has_email']);
        }

        if (array_key_exists('has_feed', $data)) {
            $obj->setHasFeed((bool) $data['has_feed']);
        }

        if (array_key_exists('has_sms', $data)) {
            $obj->setHasSms((bool) $data['has_sms']);
        }

        if (array_key_exists('link_url', $data)) {
            $obj->setLinkUrl($data['link_url']);
        }

        if (array_key_exists('email_title', $data)) {
            $this->setEmailTitle($obj, $data['email_title']);
        }

        if (array_key_exists('email_content', $data)) {
            $this->setEmailContent($obj, $data['email_content']);
        }

        if (array_key_exists('feed_title', $data)) {
            $this->setFeedTitle($obj, $data['feed_title']);
        }

        if (array_key_exists('feed_content', $data)) {
            $this->setFeedContent($obj, $data['feed_content']);
        }

        if (array_key_exists('sms_content', $data)) {
            $this->setSmsContent($obj, $data['sms_content']);
        }

        if (array_key_exists('link_text', $data)) {
            $this->setLinkText($obj, $data['link_text']);
        }

        $obj->save();

        return $obj;
    }

    public function delete(int $id): void
    {
        $obj = NotificationQuery::create()
            ->findPk($id);

        if (!$obj) {
            return;
        }

        $obj->delete();
    }

    private function setEmailTitle(Notification $obj, $value): void
    {
        if (!$value) {
            return;
        }

        foreach ($value as $k => $v) {
            if (!$v) {
                continue;
            }

            $obj->setLocale($k);
            $obj->setEmailTitle($v);
        }
    }

    private function setEmailContent(Notification $obj, $value): void
    {
        if (!$value) {
            return;
        }

        foreach ($value as $k => $v) {
            if (!$v) {
                continue;
            }

            $obj->setLocale($k);
            $obj->setEmailContent($v);
        }
    }

    private function setFeedTitle(Notification $obj, $value): void
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

    private function setFeedContent(Notification $obj, $value): void
    {
        if (!$value) {
            return;
        }

        foreach ($value as $k => $v) {
            if (!$v) {
                continue;
            }

            $obj->setLocale($k);
            $obj->setFeedContent($v);
        }
    }

    private function setSmsContent(Notification $obj, $value): void
    {
        if (!$value) {
            return;
        }

        foreach ($value as $k => $v) {
            if (!$v) {
                continue;
            }

            $obj->setLocale($k);
            $obj->setSmsContent($v);
        }
    }

    private function setLinkText(Notification $obj, $value): void
    {
        if (!$value) {
            return;
        }

        foreach ($value as $k => $v) {
            if (!$v) {
                continue;
            }

            $obj->setLocale($k);
            $obj->setLinkText($v);
        }
    }
}