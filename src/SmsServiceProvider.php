<?php

namespace Liyq\Laravel\Notifications\SMS;

use Illuminate\Notifications\ChannelManager;
use Illuminate\Support\ServiceProvider;
use Liyq\Laravel\Notifications\SMS\Channels\SmsChannel;

class SmsServiceProvider extends ServiceProvider
{
    public function register() {
        // 注册 sms 通知驱动
        $this->app->make(ChannelManager::class)
            ->extend('sms', function ($app) {
                $config = $app->config->get('notification.sms', []);
                return new SmsChannel($config);
            });

    }
}