<?php

namespace Liyq\Laravel\Notifications\SMS\Channels;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
use Illuminate\Notifications\Notification;
use Liyq\Laravel\Notifications\SMS\SmsMessage;

class SmsChannel
{
    const VERSION = '2017-05-25';
    const PRODUCT = 'Dysmsapi';
    const CLIENT_NAME = 'sms';
    protected $config;

    /**
     * SmsChannel constructor.
     *
     * @param array $config
     *
     * @throws ClientException
     */
    public function __construct(array $config) {
        $this->config = $config;
        AlibabaCloud::accessKeyClient($config['access_key_id'], $config['access_secret'])
            ->regionId($config['region'])
            ->name(self::CLIENT_NAME);

    }

    public function send($notifiable, Notification $notification) {
        if (!$to = $notifiable->routeNotificationFor('sms', $notification)) {
            return;
        }

        $message = $notification->toSms($notifiable);

        $this->sendSms($to, $message);

    }

    private function sendSms(string $mobile, SmsMessage $message) {
        try {
            if (is_array($mobile)) {
                $mobile = implode(',', $mobile);
            }

            $options = [
                'query' => [
                    'PhoneNumbers'  => $mobile,
                    'TemplateCode'  => $message->getTemplateCode(),
                    'SignName'      => $message->getSignName($this->config['sign_name']),
                    'TemplateParam' => $message->getParams()
                ]
            ];

            $result = AlibabaCloud::rpc()
                ->client(self::CLIENT_NAME)
                ->product(self::PRODUCT)
                ->version(self::VERSION)
                ->action('SendSms')
                ->method('POST')
                ->options($options)
                ->request();
            return $result->toArray();
        } catch (ServerException $exception) {

        } catch (ClientException $exception) {

        }
    }
}