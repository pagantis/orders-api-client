<?php

namespace Pagantis\OrdersApiClient\Model\Order\Discounts;

use Pagantis\OrdersApiClient\Model\AbstractModel;
use Pagantis\OrdersApiClient\Model\Order\Amount;

/**
 * Class Discount
 *
 * @package Pagantis\OrdersApiClient\Model\Order\Discounts
 */
class Discount extends AbstractModel
{
    /**
     * @var Amount $amount
     */
    protected $amount;

    /**
     * @var string $displayName the name of the discount
     */
    protected $displayName;

    /**
     * @return Amount
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param Amount $amount
     *
     * @return Discount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * @return string
     */
    public function getDisplayName()
    {
        return $this->displayName;
    }

    /**
     * @param string $displayName
     * @return Discount
     *
     */
    public function setDisplayName($displayName)
    {
        $this->displayName = $displayName;
        return $this;
    }
}
