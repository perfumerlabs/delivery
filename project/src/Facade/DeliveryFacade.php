<?php

namespace Delivery\Facade;

use Delivery\Domain\DeliveryDomain;
use Delivery\Domain\NotificationDomain;
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

    private $notification_domain;

    public function __construct(
        Queue $queue,
        DeliveryDomain $delivery_domain,
        NotificationDomain $notification_domain
    ) {
        $this->queue = $queue;

        $this->delivery_domain = $delivery_domain;

        $this->notification_domain = $notification_domain;
    }

    public function save(array $data): SaveResponse
    {
        $response = new SaveResponse();

        $validate_result = $this->validateDelivery($data);

        if ($validate_result) {
            $response->status = false;
            $response->error  = $validate_result;

            return $response;
        }

        $delivery = $this->saveDelivery($data);

        $this->saveNotification($delivery, $data['messages']);

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
//            'type'   => 'users', //customers | groups | null
//            'users'  => ['user_12', 'customer_14'], //null
//            'groups' => [12, 15], //null
//        ];

        try {
            $users = $this->getUsersData($url, $filters);
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

        $locale = $user['locale'] ?? 'ru';

        $notification->setLocale($locale);

        if ($notification->hasEmail()) {
            $emails = array_column($users, 'email');

            $this->sendEmail($emails, $notification);
        }

        if ($notification->hasSms()) {
            $phones = array_column($users, 'phone');

            $this->sendSms($phones, $notification);
        }

        if ($notification->hasFeed()) {
            $this->sendFeed($users, $notification);
        }

        //последняя итерация
        if ($max - $min <= $gap) {
            $this->delivery_domain->finish($obj);
        }

        return $response;
    }

    private function sendFeed(array $users, Notification $notification): void
    {
        foreach ($users as $user) {
            $feed_collection = $user['feed_collection'] ?? null;
            $feed_recipient  = $user['feed_recipient'] ?? null;

            $title = $notification->getFeedTitle();
            if (($title === null || $title === '') && $notification->getLocale() !== 'ru') {
                $title = $notification->setLocale('ru')->getFeedTitle();
            }

            $text = $notification->getFeedContent();
            if (($text === null || $text === '') && $notification->getLocale() !== 'ru') {
                $text = $notification->setLocale('ru')->getFeedContent();
            }

            $this->queue->sendFeed($feed_collection, $feed_recipient, $title, $text);
        }
    }

    private function sendSms(array $phones, Notification $notification): void
    {
        foreach ($phones as $key => $phone) {
            $phone = Text::sanitizePhone($phone);
            $phones[$key] = $phone;
        }

        $message = $notification->getSmsContent();

        if (($message === null || $message === '') && $notification->getLocale() !== 'ru') {
            $message = $notification->setLocale('ru')->getSmsContent();
        }

        $this->queue->sendSms($phones, $message);
    }

    private function sendEmail(array $emails, Notification $notification): void
    {
        $subject = $notification->getEmailTitle();

        if (($subject === null || $subject === '') && $notification->getLocale() !== 'ru') {
            $subject = $notification->setLocale('ru')->getEmailTitle();
        }

        if (!$subject) {
            return;
        }

        $text = $notification->getEmailContent();

        if (($text === null || $text === '') && $notification->getLocale() !== 'ru') {
            $text = $notification->setLocale('ru')->getEmailContent();
        }

        $html = '<html><body><p>' . $text . '</p>';

        if ($notification->getLinkUrl()) {
            $link_text = $notification->getLinkText();
            if ($link_text === null || $link_text === '') {
                $link_text = $notification->getLinkUrl();
            }

            $html .= '<p><a href="' . $notification->getLinkUrl() . '">' . $link_text . '</a></p>';
        }

        $html .= '</body></html>';

        $this->queue->sendEmail($emails, $subject, null, $html);
    }

    /**
     * Get users requisites. Response example:
     * [
     *    [
     *      'email' => (string) email.
     *      'phone' => (string) phone.
     *      'feed_collection' => (string) user feed collection,
     *          'feed_recipient' => (string | int) user feed recipient,
     *      'locale' => (string) user language
     *    ],
     * ]
     */
    private function getUsersData(string $url, array $filters = null): array
    {
        $client = new Client();

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

    private function saveDelivery(array $data): Delivery
    {
        $new_data = [
            'delivery' => $data['delivery'] ?? null,
            'name'     => $data['name'] ?? null,
            'data_url' => $data['data_url'] ?? null,
            'filters'  => $data['filters'] ?? null,
            'status'   => DeliveryTableMap::COL_STATUS_STARTED,
        ];

        return $this->delivery_domain->save($new_data);
    }

    private function saveNotification(Delivery $delivery, array $messages): Notification
    {
        $data = [
            'delivery'      => $delivery,
            'has_email'     => $messages['has_email'] ?? null,
            'has_feed'      => $messages['has_feed'] ?? null,
            'has_sms'       => $messages['has_sms'] ?? null,
            'link_url'      => $messages['link_url'] ?? null,
            'email_title'   => $messages['email_title'] ?? null,
            'email_content' => $messages['email_content'] ?? null,
            'feed_title'    => $messages['feed_title'] ?? null,
            'feed_content'  => $messages['feed_content'] ?? null,
            'sms_content'   => $messages['sms_content'] ?? null,
            'link_text'     => $messages['link_text'] ?? null,
        ];

        return $this->notification_domain->save($data);
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