<?php

namespace Delivery\Repository;

use Delivery\Model\Notification;
use Delivery\Model\NotificationI18nQuery;
use Delivery\Service\Timezone;

class NotificationRepository
{
    private $timezone;

    public function __construct(Timezone $timezone)
    {
        $this->timezone = $timezone;
    }

    public function format(?Notification $obj, string $locale = null): ?array
    {
        if (!$obj) {
            return null;
        }

        $created_at = $this->timezone->formatDate($obj->getCreatedAt());
        $updated_at = $this->timezone->formatDate($obj->getUpdatedAt());

        return [
            'delivery_id'   => $obj->getDeliveryId(),
            'has_email'     => $obj->getHasEmail(),
            'has_feed'      => $obj->getHasFeed(),
            'has_sms'       => $obj->getHasSms(),
            'link_url'      => $obj->getLinkUrl(),
            'email_title'   => $this->getEmailTitle($obj, $locale),
            'email_content' => $this->getEmailContent($obj, $locale),
            'feed_title'    => $this->getFeedTitle($obj, $locale),
            'feed_content'  => $this->getFeedContent($obj, $locale),
            'sms_content'   => $this->getSmsContent($obj, $locale),
            'link_text'     => $this->getLinkText($obj, $locale),
            'created_at'    => $created_at ? $created_at->format('Y-m-d H:i:s') : null,
            'updated_at'    => $updated_at ? $updated_at->format('Y-m-d H:i:s') : null,
        ];
    }

    /**
     * @param Notification[] $objs
     * @return array
     */
    public function formatCollection($objs): array
    {
        $array = [];

        foreach ($objs as $obj) {
            $array[] = $this->format($obj);
        }

        return $array;
    }

    private function getEmailTitle(Notification $obj, string $locale = null)
    {
        $result = null;

        if ($locale) {
            $result = $obj->setLocale($locale)->getEmailTitle();
        } else {
            $i18ns = NotificationI18nQuery::create()
                ->filterByNotification($obj)
                ->find();

            if ($i18ns->count() > 0) {
                $result = [];

                foreach ($i18ns as $i18n) {
                    $result[$i18n->getLocale()] = $i18n->getEmailTitle();
                }
            }
        }

        return $result;
    }

    private function getEmailContent(Notification $obj, string $locale = null)
    {
        $result = null;

        if ($locale) {
            $result = $obj->setLocale($locale)->getEmailContent();
        } else {
            $i18ns = NotificationI18nQuery::create()
                ->filterByNotification($obj)
                ->find();

            if ($i18ns->count() > 0) {
                $result = [];

                foreach ($i18ns as $i18n) {
                    $result[$i18n->getLocale()] = $i18n->getEmailContent();
                }
            }
        }

        return $result;
    }

    private function getFeedTitle(Notification $obj, string $locale = null)
    {
        $result = null;

        if ($locale) {
            $result = $obj->setLocale($locale)->getFeedTitle();
        } else {
            $i18ns = NotificationI18nQuery::create()
                ->filterByNotification($obj)
                ->find();

            if ($i18ns->count() > 0) {
                $result = [];

                foreach ($i18ns as $i18n) {
                    $result[$i18n->getLocale()] = $i18n->getFeedTitle();
                }
            }
        }

        return $result;
    }

    private function getFeedContent(Notification $obj, string $locale = null)
    {
        $result = null;

        if ($locale) {
            $result = $obj->setLocale($locale)->getFeedContent();
        } else {
            $i18ns = NotificationI18nQuery::create()
                ->filterByNotification($obj)
                ->find();

            if ($i18ns->count() > 0) {
                $result = [];

                foreach ($i18ns as $i18n) {
                    $result[$i18n->getLocale()] = $i18n->getFeedContent();
                }
            }
        }

        return $result;
    }

    private function getSmsContent(Notification $obj, string $locale = null)
    {
        $result = null;

        if ($locale) {
            $result = $obj->setLocale($locale)->getSmsContent();
        } else {
            $i18ns = NotificationI18nQuery::create()
                ->filterByNotification($obj)
                ->find();

            if ($i18ns->count() > 0) {
                $result = [];

                foreach ($i18ns as $i18n) {
                    $result[$i18n->getLocale()] = $i18n->getSmsContent();
                }
            }
        }

        return $result;
    }

    private function getLinkText(Notification $obj, string $locale = null)
    {
        $result = null;

        if ($locale) {
            $result = $obj->setLocale($locale)->getLinkText();
        } else {
            $i18ns = NotificationI18nQuery::create()
                ->filterByNotification($obj)
                ->find();

            if ($i18ns->count() > 0) {
                $result = [];

                foreach ($i18ns as $i18n) {
                    $result[$i18n->getLocale()] = $i18n->getLinkText();
                }
            }
        }

        return $result;
    }
}