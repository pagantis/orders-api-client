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
     * @var string redirectConfirmUrl URL
     */
    protected $redirectConfirmUrl = null;

    /**
     * @var string redirectCancelUrl URL
     */
    protected $redirectCancelUrl = null;

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
    public function getRedirectConfirmUrl()
    {
        return $this->redirectConfirmUrl;
    }

    /**
     * @param string $redirectConfirmUrl
     *
     * @return Merchant
     */
    public function setRedirectConfirmUrl($redirectConfirmUrl)
    {
        $this->redirectConfirmUrl = $redirectConfirmUrl;

        return $this;
    }

    /**
     * @return string
     */
    public function getRedirectCancelUrl()
    {
        return $this->redirectCancelUrl;
    }

    /**
     * @param string $redirectCancelUrl
     *
     * @return Merchant
     */
    public function setRedirectCancelUrl($redirectCancelUrl)
    {
        $this->redirectCancelUrl = $redirectCancelUrl;

        return $this;
    }
}
