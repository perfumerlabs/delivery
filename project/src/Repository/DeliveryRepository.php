<?php

namespace Delivery\Repository;

use Delivery\Model\Delivery;
use Delivery\Model\NotificationI18nQuery;
use Delivery\Service\Timezone;

class DeliveryRepository
{
    private $timezone;

    public function __construct(Timezone $timezone)
    {
        $this->timezone = $timezone;
    }

    public function format(?Delivery $obj, bool $with_notif = false, string $locale = null): ?array
    {
        if (!$obj) {
            return null;
        }

        $created_at = $this->timezone->formatDate($obj->getCreatedAt());
        $updated_at = $this->timezone->formatDate($obj->getUpdatedAt());

        $result = [
            'id'         => $obj->getId(),
            'name'       => $obj->getName(),
            'has_email'  => $obj->getHasEmail(),
            'has_feed'   => $obj->getHasFeed(),
            'has_sms'    => $obj->getHasSms(),
            'status'     => $obj->getStatus(),
            'progress'   => $obj->getNbAllNotifications() ? $obj->getNbSentNotifications()
                / $obj->getNbAllNotifications() : 0,
            'created_at' => $created_at ? $created_at->format('Y-m-d H:i:s') : null,
            'updated_at' => $updated_at ? $updated_at->format('Y-m-d H:i:s') : null,
        ];

        if ($with_notif) {
            $result['data_url']      = $obj->getDataUrl();
            $result['filters']       = $obj->getFilters();
            $result['email_subject'] = $this->getEmailSubject($obj, $locale);
            $result['email_html']    = $this->getEmailHtml($obj, $locale);
            $result['sms_message']   = $this->getSmsMessage($obj, $locale);
            $result['feed_title']    = $this->getFeedTitle($obj, $locale);
            $result['feed_text']     = $this->getFeedText($obj, $locale);
            $result['feed_image']    = $this->getFeedImage($obj, $locale);
            $result['feed_payload']  = $obj->getFeedPayload();
            $result['payload']       = $obj->getPayload();
        }

        return $result;
    }

    /**
     * @param Delivery[] $objs
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

    private function getEmailSubject(Delivery $obj, string $locale = null): ?array
    {
        $result = null;

        if ($locale) {
            $result = $obj->setLocale($locale)->getEmailSubject();
        } else {
            $i18ns = NotificationI18nQuery::create()
                ->filterByNotification($obj->getNotification())
                ->find();

            if ($i18ns->count() > 0) {
                $result = [];

                foreach ($i18ns as $i18n) {
                    $result[$i18n->getLocale()] = $i18n->getEmailSubject();
                }
            }
        }

        return $result;
    }

    private function getEmailHtml(Delivery $obj, string $locale = null): ?array
    {
        $result = null;

        if ($locale) {
            $result = $obj->setLocale($locale)->getEmailHtml();
        } else {
            $i18ns = NotificationI18nQuery::create()
                ->filterByNotification($obj->getNotification())
                ->find();

            if ($i18ns->count() > 0) {
                $result = [];

                foreach ($i18ns as $i18n) {
                    $result[$i18n->getLocale()] = $i18n->getEmailHtml();
                }
            }
        }

        return $result;
    }

    private function getSmsMessage(Delivery $obj, string $locale = null): ?array
    {
        $result = null;

        if ($locale) {
            $result = $obj->setLocale($locale)->getSmsMessage();
        } else {
            $i18ns = NotificationI18nQuery::create()
                ->filterByNotification($obj->getNotification())
                ->find();

            if ($i18ns->count() > 0) {
                $result = [];

                foreach ($i18ns as $i18n) {
                    $result[$i18n->getLocale()] = $i18n->getSmsMessage();
                }
            }
        }

        return $result;
    }

    private function getFeedTitle(Delivery $obj, string $locale = null): ?array
    {
        $result = null;

        if ($locale) {
            $result = $obj->setLocale($locale)->getFeedTitle();
        } else {
            $i18ns = NotificationI18nQuery::create()
                ->filterByNotification($obj->getNotification())
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

    private function getFeedText(Delivery $obj, string $locale = null): ?array
    {
        $result = null;

        if ($locale) {
            $result = $obj->setLocale($locale)->getFeedText();
        } else {
            $i18ns = NotificationI18nQuery::create()
                ->filterByNotification($obj->getNotification())
                ->find();

            if ($i18ns->count() > 0) {
                $result = [];

                foreach ($i18ns as $i18n) {
                    $result[$i18n->getLocale()] = $i18n->getFeedText();
                }
            }
        }

        return $result;
    }

    private function getFeedImage(Delivery $obj, string $locale = null): ?array
    {
        $result = null;

        if ($locale) {
            $result = $obj->setLocale($locale)->getFeedImage();
        } else {
            $i18ns = NotificationI18nQuery::create()
                ->filterByNotification($obj->getNotification())
                ->find();

            if ($i18ns->count() > 0) {
                $result = [];

                foreach ($i18ns as $i18n) {
                    $result[$i18n->getLocale()] = $i18n->getFeedImage();
                }
            }
        }

        return $result;
    }
}