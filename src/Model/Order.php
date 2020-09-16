<?php

namespace Pagantis\OrdersApiClient\Model;

use Pagantis\OrdersApiClient\Model\Order\Discounts\Discount;
use Pagantis\OrdersApiClient\Model\Order\Items\Product;
use Pagantis\OrdersApiClient\Model\Order\Merchant;
use Pagantis\OrdersApiClient\Model\Order\Address;
use Pagantis\OrdersApiClient\Model\Order\Consumer;
use Pagantis\OrdersApiClient\Model\Order\Courier;
use Pagantis\OrdersApiClient\Model\Order\Amount;

/**
 * Class Order
 *
 * @package Pagantis\OrdersApiClient\Model
 */
class Order extends AbstractModel
{
    /**
     * @var string $token
     */
    protected $token = null;

    /**
     * @var string $expires
     */
    protected $expires = null;

    /**
     * @var string $merchantReference
     */
    protected $merchantReference = null;

    /**
     * @var string $description
     */
    protected $description = null;

    /**
     * @var Amount $totalAmount
     */
    protected $totalAmount;

    /**
     * @var Merchant $merchant
     */
    protected $merchant;

    /**
     * @var Address $shipping
     */
    protected $shipping;

    /**
     * @var Address $billing
     */
    protected $billing;

    /**
     * @var string $status
     */
    protected $status;

    /**
     * @var Consumer $consumer
     */
    protected $consumer;

    /**
     * @var Courier $courier
     */
    protected $courier;

    /**
     * @var Product[] $items
     */
    protected $items;

    /**
     * @var Discount[] $discounts
     */
    protected $discounts;

    /**
     * @var Amount $taxAmount
     */
    protected $taxAmount;

    /**
     * @var Amount $shippingAmount
     */
    protected $shippingAmount;


    /**
     * Order constructor.
     */
    public function __construct()
    {
        $this->totalAmount = new Amount();
        $this->consumer = new Consumer();
        $this->billing = new Address();
        $this->shipping = new Address();
        $this->merchant = new Merchant();
        $this->courier = new Courier();
        $this->items = array();
        $this->discounts = array();
    }

    /**
     * @return Amount
     */
    public function getTotalAmount()
    {
        return $this->totalAmount;
    }

    /**
     * @param Amount $totalAmount
     *
     * @return Order
     */
    public function setTotalAmount($totalAmount)
    {
        $this->totalAmount = $totalAmount;

        return $this;
    }

    /**
     * @return Courier
     */
    public function getCourier()
    {
        return $this->courier;
    }

    /**
     * @param Courier $courier
     *
     * @return Order
     */
    public function setCourier($courier)
    {
        $this->courier = $courier;

        return $this;
    }

    /**
     * @param String $token
     *
     * @return Order
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param String $expires
     *
     * @return Order
     */
    public function setExpires($expires)
    {
        $this->expires = $expires;

        return $this;
    }

    /**
     * @return string
     */
    public function getExpires()
    {
        return $this->expires;
    }

    /**
     * @return Address
     */
    public function getShippingAddress()
    {
        return $this->shipping;
    }

    /**
     * @param Address $shipping
     *
     * @return Order
     */
    public function setShippingAddress($shipping)
    {
        $this->shipping = $shipping;

        return $this;
    }

    /**
     * @return Address
     */
    public function getBillingAddress()
    {
        return $this->billing;
    }

    /**
     * @param Address $billing
     *
     * @return Order
     */
    public function setBillingAddress($billing)
    {
        $this->billing = $billing;

        return $this;
    }

    /**
     * @return Merchant()
     */
    public function getMerchant()
    {
        return $this->merchant;
    }

    /**
     * @param Merchant() $merchant
     *
     * @return Order
     */
    public function setMerchant($merchant)
    {
        $this->merchant = $merchant;

        return $this;
    }

    /**
     * @return Consumer()
     */
    public function getConsumer()
    {
        return $this->consumer;
    }

    /**
     * @param Consumer() $consumer
     *
     * @return Order
     */
    public function setConsumer($consumer)
    {
        $this->consumer = $consumer;

        return $this;
    }

    /**
     * @return Product[]
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @param Product() $product
     *
     * @return Order
     */
    public function addItem(Product $product)
    {
        $this->items[] = $product;

        return $this;
    }

    /**
     * @return Discount[]
     */
    public function getDiscounts()
    {
        return $this->discounts;
    }

    /**
     * @param Discount() $discount
     *
     * @return Order
     */
    public function addDiscount($discount)
    {
        $this->discounts[] = $discount;

        return $this;
    }

    /**
     * @return Amount
     */
    public function getTaxAmount()
    {
        return $this->taxAmount;
    }

    /**
     * @param Amount $taxAmount
     *
     * @return Order
     */
    public function setTaxAmount($taxAmount)
    {
        $this->taxAmount = $taxAmount;

        return $this;
    }

    /**
     * @return Amount
     */
    public function getShippingAmount()
    {
        return $this->shippingAmount;
    }

    /**
     * @param Amount $shippingAmount
     *
     * @return Order
     */
    public function setShippingAmount($shippingAmount)
    {
        $this->shippingAmount = $shippingAmount;

        return $this;
    }

    /**
     * @return String
     */
    public function getMerchantReference()
    {
        return $this->merchantReference;
    }

    /**
     * @param Amount $merchantReference
     *
     * @return Order
     */
    public function setMerchantReference($merchantReference)
    {
        $this->merchantReference = $merchantReference;

        return $this;
    }

    /**
     * @return String
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param Amount $description
     *
     * @return Order
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }
}
