<?php

namespace Delivery\Facade;

use Delivery\Domain\DeliveryDomain;
use Delivery\Helper\Text;
use Delivery\Model\Delivery;
use Delivery\Model\DeliveryQuery;
use Delivery\Model\Map\DeliveryTableMap;
use Delivery\Model\Notification;
use Delivery\Response\Facade\DeliveryFacade\SaveResponse;
use Delivery\Response\Facade\DeliveryFacade\SendResponse;
use Delivery\Service\Queue;
use GuzzleHttp\Client;

class DeliveryFacade
{
    private $queue;

    private $delivery_domain;

    public function __construct(
        Queue $queue,
        DeliveryDomain $delivery_domain
    ) {
        $this->queue = $queue;

        $this->delivery_domain = $delivery_domain;
    }

    public function save(array $data, Delivery $obj = null): SaveResponse
    {
        $response = new SaveResponse();

        $validate_result = $this->validateDelivery($data);

        if ($validate_result) {
            $response->status = false;
            $response->error  = $validate_result;

            return $response;
        }

        $delivery = $this->saveDelivery($data, $obj);

        $this->queue->sendDelivery($delivery->getId(), $data['min'], $data['max'], $data['gap']);

        return $response;
    }

    public function send(int $delivery_id, int $min, int $max, int $gap): SendResponse
    {
        $response = new SendResponse();

        if (!$delivery_id) {
            $response->status = false;
            $response->error  = 'Передайте валидный ID рассылки';

            return $response;
        }

        $obj = DeliveryQuery::create()
            ->joinWithNotification()
            ->findPk($delivery_id);

        if (!$obj) {
            $response->status = false;
            $response->error  = 'Рассылка не найдена или была удалена';

            return $response;
        }

        //if delivery canceled or finished then exit
        if ($obj->getStatus() !== DeliveryTableMap::COL_STATUS_STARTED) {
            return $response;
        }

        $notification = $obj->getNotification();
        if (!$notification) {
            $response->status = false;
            $response->error  = 'Не найдено уведомление для рассылки';

            return $response;
        }

        $url = $obj->getDataUrl();

        if (!$url) {
            $response->status = false;
            $response->error  = 'Нет data_url';

            return $response;
        }

        $filters = $obj->getFilters();

        if ($filters !== null) {
            $filters = json_decode($filters, true);
        }

//        $filters = [
//            'type'   => 'users', //users | customers | groups | null
//            'id'  => ['12', '14'], //null
//            'groups' => [12, 15], //null
//        ];

        if (!$filters) {
            $filters = [];
        }

        $filters['id_from'] = $min;
        $filters['id_to'] = $max;

        try {
            $users = $this->getUsersData($url, $filters);

            error_log('[CUSTOM LOG] users = ' . print_r($users, true) . PHP_EOL);
//            $users = [
//                [
//                    'email' => 'torbayevnurbek1992@gmail.com',
//                ]
//            ];
        } catch (\Exception $e) {
            $response->status = false;
            $response->error  = $e->getMessage();

            return $response;
        }

        if (!$users) {
            $response->status = false;
            $response->error  = 'Нет пользователей для отправки уведомлений';

            return $response;
        }

        $locales = array_column($users, 'locale');
        $locales = array_unique($locales);

        foreach ($locales as $locale) {
            $notification->setLocale($locale);

            if ($obj->hasEmail()) {
                $this->sendEmail($users, $notification);
            }

            if ($obj->hasSms()) {
                $phones = array_column($users, 'phone');
                $this->sendSms($phones, $notification);
            }

            if ($obj->hasFeed()) {
                $this->sendFeed($users, $notification);
            }
        }

        $this->delivery_domain->increaseSentNotifications($obj, $max - $min + 1);

        //последняя итерация
        if ($obj->getNbSentNotifications() >= $obj->getNbAllNotifications()) {
            $this->delivery_domain->finish($obj);
        }

        return $response;
    }

    private function sendFeed(array $users, Notification $notification): void
    {
        $title = $notification->getFeedTitle();
        if (($title === null || $title === '') && $notification->getLocale() !== 'ru') {
            $title = $notification->setLocale('ru')->getFeedTitle();
        }

        $text = $notification->getFeedText();
        if (($text === null || $text === '') && $notification->getLocale() !== 'ru') {
            $text = $notification->setLocale('ru')->getFeedText();
        }

        $image = $notification->getFeedText();
        if (($image === null || $image === '') && $notification->getLocale() !== 'ru') {
            $image = $notification->setLocale('ru')->getFeedImage();
        }

        foreach ($users as $user) {
            $feed_collection = $user['feed_collection'] ?? null;
            $feed_recipient  = $user['feed_recipient'] ?? null;

            $this->queue->sendFeed(
                $feed_collection,
                $feed_recipient,
                $title,
                $text,
                $image,
                $notification->getFeedPayload()
            );
        }
    }

    private function sendSms(array $phones, Notification $notification): void
    {
        foreach ($phones as $key => $phone) {
            $phone        = Text::sanitizePhone($phone);
            $phones[$key] = $phone;
        }

        $message = $notification->getSmsMessage();

        if (($message === null || $message === '') && $notification->getLocale() !== 'ru') {
            $message = $notification->setLocale('ru')->getSmsMessage();
        }

        $this->queue->sendSms($phones, $message);
    }

    private function sendEmail(array $users, Notification $notification): void
    {
        $subject = $notification->getEmailSubject();

        if (($subject === null || $subject === '') && $notification->getLocale() !== 'ru') {
            $subject = $notification->setLocale('ru')->getEmailSubject();
        }

        if (!$subject) {
            return;
        }

        $html = $notification->getEmailHtml();

        if (($html === null || $html === '') && $notification->getLocale() !== 'ru') {
            $html = $notification->setLocale('ru')->getEmailHtml();
        }

        foreach ($users as $user) {
            $email = $user['email'] ?? null;
            if (!$email) {
                continue;
            }

            $this->queue->sendEmail($email, $subject, null, $html);
        }
    }

    /**
     * Get users requisites. Response example:
     * [
     *    [
     *      'email' => (string) email.
     *      'phone' => (string) phone.
     *      'feed_collection' => (string) user feed collection,
     *      'feed_recipient' => (string | int) user feed recipient,
     *      'locale' => (string) user language
     *    ],
     * ]
     */
    private function getUsersData(string $url, array $filters): array
    {
        $client = new Client();

        error_log('[CUSTOM LOG] getUsersData(). filters: ' . print_r($filters, true) . PHP_EOL);

        $guzzle_response = $client->get(
            $url,
            [
                'connect_timeout' => 15,
                'read_timeout'    => 15,
                'timeout'         => 15,
                'json'            => $filters,
            ]
        );

        $guzzle_response = json_decode($guzzle_response->getBody()->getContents(), true);

        if (isset($guzzle_response['content']) && is_array($guzzle_response['content'])) {
            return $guzzle_response['content'];
        }

        return [];
    }

    private function saveDelivery(array $data, Delivery $obj = null): Delivery
    {
        $new_data = [
            'delivery'             => $obj,
            'name'                 => $data['name'] ?? null,
            'has_email'            => $data['has_email'] ?? null,
            'has_feed'             => $data['has_feed'] ?? null,
            'has_sms'              => $data['has_sms'] ?? null,
            'status'               => DeliveryTableMap::COL_STATUS_STARTED,
            'nb_all_notifications' => $data['max'] - $data['min'] + 1,
            'email_subject'        => $data['email_subject'] ?? null,
            'email_html'           => $data['email_html'] ?? null,
            'sms_message'          => $data['sms_message'] ?? null,
            'feed_title'           => $data['feed_title'] ?? null,
            'feed_text'            => $data['feed_text'] ?? null,
            'feed_image'           => $data['feed_image'] ?? null,
            'feed_payload'         => $data['feed_payload'] ?? null,
            'payload'              => $data['payload'] ?? null,
        ];

        if (!$obj || $obj->getStatus() === DeliveryTableMap::COL_STATUS_WAITING) {
            $new_data['data_url'] = $data['data_url'] ?? null;
            $new_data['filters']  = $data['filters'] ?? null;
        }

        return $this->delivery_domain->save($new_data);
    }

    private function validateDelivery(array $data): ?string
    {
        $error = null;

        $min      = $data['min'] ?? null;
        $max      = $data['max'] ?? null;
        $gap      = $data['gap'] ?? null;
        $name     = $data['name'] ?? null;
        $messages = $data['messages'] ?? null;
        $filters  = $data['filters'] ?? null;
        $data_url = $data['data_url'] ?? null;

        if ($name === null || $name === '') {
            $error = 'Name required';
        } elseif ($min === null || !is_int($min)) {
            $error = 'Queue min param required';
        } elseif ($max === null || !is_int($max)) {
            $error = 'Queue max param required';
        } elseif ($gap === null || !is_int($gap)) {
            $error = 'Queue gap param required';
        } elseif (!$messages) {
            $error = 'Messages required';
        } elseif (!$filters) {
            $error = 'Filters required';
        } elseif (!$data_url) {
            $error = 'Data url required';
        }

        return $error;
    }
}