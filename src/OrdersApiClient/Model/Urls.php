<?php

namespace PagaMasTarde\OrdersApiClient\Model;

use PagaMasTarde\OrdersApiClient\Exception\UrlException;

/**
 * Class Urls
 * @package PagaMasTarde\OrdersApiClient\Model
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
     * @return mixed
     */
    protected function urlValidate($url)
    {
        //TODO Investigate why filter_var gives PHPStorm Warning
        return false === filter_var($url, FILTER_VALIDATE_URL);
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
     *
     * @throws UrlException
     */
    public function setCancel($cancel)
    {
        if ($this->urlValidate($cancel)) {
            $this->cancel = $cancel;
            return $this;
        }

        throw new UrlException('Invalid Cancel Url');
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
     *
     * @throws UrlException
     */
    public function setKo($ko)
    {
        if ($this->urlValidate($ko)) {
            $this->ko = $ko;
            return $this;
        }

        throw new UrlException('Invalid Ko Url');
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
     *
     * @throws UrlException
     */
    public function setNotificationCallback($notificationCallback)
    {
        if ($this->urlValidate($notificationCallback)) {
            $this->notificationCallback = $notificationCallback;
            return $this;
        }

        throw new UrlException('Invalid NotificationCallback Url');
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
     *
     * @throws UrlException
     */
    public function setOk($ok)
    {
        if ($this->urlValidate($ok)) {
            $this->ok = $ok;
            return $this;
        }

        throw new UrlException('Invalid Ok Url');
    }
}
