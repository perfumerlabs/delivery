<?php

namespace Delivery\Service;

use GuzzleHttp\Client;

class Queue
{
    private $queue_url;

    private $sms_url;

    private $email_url;

    private $feed_url;

    private $delivery_url;

    private $sms_worker;

    private $email_worker;

    private $feed_worker;

    private $delivery_fraction_worker;

    public function __construct(
        $queue_url,
        $sms_url,
        $email_url,
        $feed_url,
        $delivery_url,
        $sms_worker,
        $email_worker,
        $feed_worker,
        $delivery_fraction_worker
    ) {
        $this->queue_url                = $queue_url;
        $this->sms_url                  = $sms_url;
        $this->email_url                = $email_url;
        $this->feed_url                 = $feed_url;
        $this->delivery_url             = $delivery_url;
        $this->sms_worker               = $sms_worker;
        $this->email_worker             = $email_worker;
        $this->feed_worker              = $feed_worker;
        $this->delivery_fraction_worker = $delivery_fraction_worker;
    }

    public function sendSms($phone, $message): bool
    {
        try {
            $client = new Client();
            $client->post(
                $this->queue_url . '/task',
                [
                    'connect_timeout' => 15,
                    'read_timeout'    => 15,
                    'timeout'         => 15,
                    'json'            => [
                        'url'    => sprintf('%s/sms', $this->sms_url),
                        'method' => 'post',
                        'worker' => $this->sms_worker,
                        'json'   => [
                            'phones'  => $phone,
                            'message' => $message,
                            'force'   => true,
                        ],
                    ],
                ]
            );
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }

    public function sendEmail($email, $subject, $text, $html): bool
    {
        try {
            $client = new Client();
            $client->post(
                $this->queue_url . '/task',
                [
                    'connect_timeout' => 15,
                    'read_timeout'    => 15,
                    'timeout'         => 15,
                    'json'            => [
                        'url'    => sprintf('%s/smtp', $this->email_url),
                        'method' => 'post',
                        'worker' => $this->email_worker,
                        'json'   => [
                            'to'      => $email,
                            'subject' => $subject,
                            'text'    => $text,
                            'html'    => $html,
                            'force'   => true,
                        ],
                    ],
                ]
            );
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }

    public function sendFeed(
        ?string $collection,
        ?string $recipient,
        string $title = null,
        string $text = null,
        string $image = null,
        array $payload = null
    ): bool {
        try {
            $client = new Client();
            $client->post(
                $this->queue_url . '/task',
                [
                    'connect_timeout' => 15,
                    'read_timeout'    => 15,
                    'timeout'         => 15,
                    'json'            => [
                        'url'    => sprintf('%s/record', $this->feed_url),
                        'method' => 'post',
                        'worker' => $this->feed_worker,
                        'json'   => [
                            'collection' => $collection,
                            'recipient'  => $recipient,
                            'title'      => $title,
                            'text'       => $text,
                            'image'      => $image,
                            'payload'    => $payload,
                        ],
                    ],
                ]
            );
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }

    public function sendDelivery($delivery_id, $min, $max, $gap): bool
    {
        try {
            $client = new Client();
            $body = [
                'debug' => true,
                'connect_timeout' => 15,
                'read_timeout'    => 15,
                'timeout'         => 15,
                'json'            => [
                    'worker' => $this->delivery_fraction_worker,
                    'url'    => sprintf('%s/delivery/send', $this->delivery_url),
                    'method' => 'post',
                    'json'   => [
                        'id' => $delivery_id,
                    ],
                    'min'    => $min,
                    'max'    => $max,
                    'gap'    => $gap,
                ],
            ];

            $response = $client->post(
                $this->queue_url . '/fraction',
                $body
            );

            error_log('[CUSTOM LOG] Send delivery to queue. URL: ' . $this->queue_url . '/fraction' . PHP_EOL);
            error_log('[CUSTOM LOG] Send delivery to queue. Data: ' . print_r($body, true) . PHP_EOL);

            error_log('[CUSTOM LOG] Send delivery to queue. RESPONSE: ' . $response->getBody()->getContents() . PHP_EOL);
        } catch (\Exception $e) {
            throw $e;
        }

        return true;
    }
}