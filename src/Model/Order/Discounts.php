<?php

namespace Pagantis\OrdersApiClient\Model\Order;

use Pagantis\OrdersApiClient\Model\AbstractModel;
use Pagantis\OrdersApiClient\Model\Order\Discounts\Discount;

/**
 * Class Discounts
 * @package Pagantis\OrdersApiClient\Model\Order
 */
class Discounts extends AbstractModel
{
    /**
     * @var Discount[]
     */
    protected $discounts;

    /**
     * Discounts constructor.
     */
    public function __construct()
    {
        $this->discounts = array();
    }

    /**
     * @return Discount[]
     */
    public function getDiscounts()
    {
        return $this->discounts;
    }

    /**
     * @param Discount $product
     *
     * @return Discounts
     */
    public function addDiscount(Discount $product)
    {
        $this->discounts[] = $product;

        return $this;
    }
}
