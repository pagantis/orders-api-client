<?php

namespace PagaMasTarde\OrdersApiClient\Model\Order\Configuration;

use Exceptions\Data\ValidationException;
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
        if ($this->urlValidate($cancel)) {
            $this->cancel = $cancel;
            return $this;
        }

        throw new ValidationException('Invalid Cancel Url');
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
        if ($this->urlValidate($ko)) {
            $this->ko = $ko;
            return $this;
        }

        throw new ValidationException('Invalid Ko Url');
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
        if ($this->urlValidate($notificationCallback)) {
            $this->notificationCallback = $notificationCallback;
            return $this;
        }

        throw new ValidationException('Invalid NotificationCallback Url');
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
        if ($this->urlValidate($ok)) {
            $this->ok = $ok;
            return $this;
        }

        throw new ValidationException('Invalid Ok Url');
    }

    /**
     * Check KO and OK as mandatory, trigger setters for validation
     *
     * @return bool|true
     */
    public function validate()
    {
        $this->triggerSetters();

        if (!empty($this->ok) && !(empty($this->ko))) {
            return true;
        }

        throw new ValidationException('Ok and Ko URL can not be empty');
    }
}
