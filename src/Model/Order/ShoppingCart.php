<?php

namespace PagaMasTarde\OrdersApiClient\Model\Order;

use Exceptions\Data\ValidationException;
use PagaMasTarde\OrdersApiClient\Model\AbstractModel;
use PagaMasTarde\OrdersApiClient\Model\Order\ShopingCart\Details;

/**
 * Class ShoppingCart
 * @package PagaMasTarde\OrdersApiClient\Model\Order
 */
class ShoppingCart extends AbstractModel
{
    /**
     * @var Details $details
     */
    protected $details;

    /**
     * @var string $order_reference Order reference in merchant side
     */
    protected $orderReference;

    /**
     * @var int $promotedAmount The part in cents from the totalAmount that is promoted
     */
    protected $promotedAmount;

    /**
     * @var int $totalAmount The total amount of the order in cents that will be charged to the user
     */
    protected $totalAmount;

    /**
     * Not adding setters nor getters
     *
     * @deprecated
     */
    protected $deprecatedOrderDescription;

    /**
     * ShoppingCart constructor.
     */
    public function __construct()
    {
        $this->details = new Details();
    }

    /**
     * @return Details
     */
    public function getDetails()
    {
        return $this->details;
    }

    /**
     * @param Details $details
     *
     * @return ShoppingCart
     */
    public function setDetails($details)
    {
        $this->details = $details;

        return $this;
    }

    /**
     * @return string
     */
    public function getOrderReference()
    {
        return $this->orderReference;
    }

    /**
     * @param string $orderReference
     *
     * @return ShoppingCart
     */
    public function setOrderReference($orderReference)
    {
        $this->orderReference = $orderReference;

        return $this;
    }

    /**
     * @return int
     */
    public function getPromotedAmount()
    {
        return $this->promotedAmount;
    }

    /**
     * @param int $promotedAmount
     *
     * @return ShoppingCart
     */
    public function setPromotedAmount($promotedAmount)
    {
        if ($promotedAmount >= 0 && is_int($promotedAmount)) {
            $this->promotedAmount = $promotedAmount;
            return $this;
        }

        throw new ValidationException('Promoted amount has to be natural number');
    }

    /**
     * @return int
     */
    public function getTotalAmount()
    {
        return $this->totalAmount;
    }

    /**
     * @param int $totalAmount
     *
     * @return ShoppingCart
     */
    public function setTotalAmount($totalAmount)
    {
        if ($totalAmount >= 1 && is_int($totalAmount)) {
            $this->totalAmount = $totalAmount;
            return $this;
        }

        throw new ValidationException('Total amount has to be a non zero natural number');
    }
}
