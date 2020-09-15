<?php

namespace Pagantis\OrdersApiClient\Model\Order;

use Pagantis\OrdersApiClient\Model\AbstractModel;

/**
 * Class Merchant
 * @package Pagantis\OrdersApiClient\Model\Order\Configuration
 */
class Merchant extends AbstractModel
{
    /**
     * @var string cancel URL
     */
    protected $cancel = null;

    /**
     * @var string confirm URL
     */
    protected $confirm = null;

    /**
     * @param $url
     *
     * @return bool
     */
    public static function urlValidate($url)
    {
        return false !== filter_var($url, FILTER_VALIDATE_URL);
    }

    /**
     * @return string
     */
    public function getCancel()
    {
        return $this->cancel;
    }

    /**
     * @param string $cancel
     *
     * @return Merchant
     */
    public function setCancel($cancel)
    {
        $this->cancel = $cancel;

        return $this;
    }

    /**
     * @return string
     */
    public function getConfirm()
    {
        return $this->confirm;
    }

    /**
     * @param string $confirm
     *
     * @return Merchant
     */
    public function setConfirm($confirm)
    {
        $this->confirm = $confirm;

        return $this;
    }
}
