<?php

namespace PagaMasTarde\OrdersApiClient\Model\Order\Configuration;

use PagaMasTarde\OrdersApiClient\Model\AbstractModel;

/**
 * Class Urls
 * @package PagaMasTarde\OrdersApiClient\Model\Order\Configuration
 */
class Urls extends AbstractModel
{
    /**
     * @var string cancel URL
     */
    protected $cancel = null;

    /**
     * @var string ko URL
     */
    protected $ko = null;

    /**
     * @var string $notificationCallback URL
     */
    protected $notificationCallback = null;

    /**
     * @var string ok URL
     */
    protected $ok = null;

    /**
     * @param $url
     *
     * @return bool
     */
    public static function urlValidate($url)
    {
        return filter_var($url, FILTER_VALIDATE_URL) !== false;
    }

    /**
     * @return string
     */
    public function getCancel()
    {
        return $this->cancel;
    }

    /**
     * @param $cancel
     *
     * @return $this
     */
    public function setCancel($cancel)
    {
        $this->cancel = $cancel;

        return $this;
    }

    /**
     * @return string
     */
    public function getKo()
    {
        return $this->ko;
    }

    /**
     * @param $ko
     *
     * @return $this
     */
    public function setKo($ko)
    {
        $this->ko = $ko;

        return $this;
    }

    /**
     * @return string
     */
    public function getNotificationCallback()
    {
        return $this->notificationCallback;
    }

    /**
     * @param $notificationCallback
     *
     * @return $this
     */
    public function setNotificationCallback($notificationCallback)
    {
        $this->notificationCallback = $notificationCallback;

        return $this;
    }

    /**
     * @return string
     */
    public function getOk()
    {
        return $this->ok;
    }

    /**
     * @param $ok
     *
     * @return $this
     */
    public function setOk($ok)
    {
        $this->ok = $ok;

        return $this;
    }
}
