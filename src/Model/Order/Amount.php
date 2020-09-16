<?php

namespace Pagantis\OrdersApiClient\Model\Order;

use Pagantis\OrdersApiClient\Model\AbstractModel;

/**
 * Class Amount
 * @package Pagantis\OrdersApiClient\Model\Order
 */
class Amount extends AbstractModel
{
    /**
     * @var string $amount Amount amount in decimal (30,2).
     */
    protected $amount;

    /**
     * @var string $currency The currency in ISO 4217 format. Only "GBP, EUR" is supported. Default 'EUR'
     */
    protected $currency;

    /**
     * Configuration constructor.
     */
    public function __construct()
    {
        $this->setCurrency('EUR');
    }

    /**
     * @return string
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param $amount
     *
     * @return $this
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @param string $currency
     *
     * @return Amount
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;

        return $this;
    }
}
