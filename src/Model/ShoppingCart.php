<?php

namespace PagaMasTarde\OrdersApiClient\Model;

use PagaMasTarde\OrdersApiClient\Exception\ShoppingCartException;

/**
 * Class ShoppingCart
 * @package PagaMasTarde\OrdersApiClient\Model
 */
class ShoppingCart extends AbstractModel
{
    /**
     * @var Product[]
     */
    protected $products;

    /**
     * @var int $shipping_cost Shipping cost for the order
     */
    protected $shippingCost;

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
     * ShoppingCart constructor.
     */
    public function __construct()
    {
        $this->products = array();
    }

    /**
     * @return Product[]
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * @param Product $product
     *
     * @return ShoppingCart
     */
    public function addProduct(Product $product)
    {
        $this->products[] = $product;

        return $this;
    }

    /**
     * @return int
     */
    public function getShippingCost()
    {
        return $this->shippingCost;
    }

    /**
     * @param int $shippingCost
     *
     * @return ShoppingCart
     *
     * @throws ShoppingCartException
     */
    public function setShippingCost($shippingCost)
    {
        if ($shippingCost >= 0 && is_int($shippingCost)) {
            $this->shippingCost = $shippingCost;
            return $this;
        }

        throw new ShoppingCartException('Shipping cost has to be natural number');
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
     *
     * @throws ShoppingCartException
     */
    public function setPromotedAmount($promotedAmount)
    {
        if ($promotedAmount >= 0 && is_int($promotedAmount)) {
            $this->promotedAmount = $promotedAmount;
            return $this;
        }

        throw new ShoppingCartException('Promoted amount has to be natural number');
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
     *
     * @throws ShoppingCartException
     */
    public function setTotalAmount($totalAmount)
    {
        if ($totalAmount >= 1 && is_int($totalAmount)) {
            $this->totalAmount = $totalAmount;
            return $this;
        }

        throw new ShoppingCartException('Total amount has to be a non zero natural number');
    }
}
