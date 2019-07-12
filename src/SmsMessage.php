<?php


namespace Liyq\Laravel\Notifications\SMS;

/**
 * 短信消息类
 * Class SmsMessage
 *
 * @package Liyq\Laravel\Notifications\SMS
 *
 * author liyq <2847895875@qq.com>
 */
class SmsMessage
{
    /**
     * 消息模板id
     * @var integer|string
     */
    protected $templateCode;

    /**
     * 模板变量参数
     * @var array
     */
    protected $params = [];

    /**
     * 短信签名，可选
     *
     * @var string|null
     */
    protected $signName;

    public static function create($templateCode, array $params = [], ?string $signName = null) {
        return new static($templateCode, $params, $signName);
    }

    public function __construct($templateCode, array $params = [], ?string $signName = null) {
        $this->templateCode = $templateCode;
        $this->params = $params;
        $this->signName = $signName;
    }

    public function getSignName($default = null) {
        return $this->signName ?? $default;
    }

    public function getParams() {
        return json_encode($this->params) ?? '';
    }

    public function getTemplateCode() {
        return $this->templateCode;
    }

}