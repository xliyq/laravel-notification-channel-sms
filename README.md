# 短信网关在 Laravel 通知的支持

## 要求
* php >= 7.1
* Laravel >= 5.5

## 安装
```
composer required liyq/laravel-notification-channel-sms
```

## 配置
在 `config/notification.php`中进行如下配置
```php

return [
    ....
    
    'sms'=>[
        'access_key_id' => env('ALIYUN_ACCESS_KEY_ID', ''),
        'access_secret' => env('ALIYUM_ACCESS_SECRET', ''),
        'sign_name'     => env('ALIYUM_SMS_SIGN_NAME', ''),
        'region'        => env('ALIYUM_SMS_REGION', '')
    ],

]
```

然后在 `.env` 文件中进行配置：

```text
ALIYUN_ACCESS_KEY_ID=
ALIYUM_ACCESS_SECRET=
ALIYUM_SMS_SIGN_NAME=
ALIYUM_SMS_REGION=
```

## 使用
### 数据模型类
```php
<?php

use Illuminate\Foundation\Auth\User as Authenticatable;
class User extends Authenticatable{
    
    protected function routeNotificationForSms(){
        return  $this->mobile;
    }
    
}
```

### 通知类
```php
<?php
class DemoNotification extends \Illuminate\Notifications\Notification{
    
    public function toSms($notification){
        return  \Liyq\Laravel\Notifications\SMS\SmsMessage::create($templateCode,$param=[],$signName);
    }
    
    public function via(){
        return ['sms'];
    }
}
```
