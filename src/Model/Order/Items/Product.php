<?php

namespace Pagantis\OrdersApiClient\Model\Order\Items;

use Pagantis\OrdersApiClient\Model\AbstractModel;
use Pagantis\OrdersApiClient\Model\Order\Amount;

/**
 * Class Product
 * @package Pagantis\OrdersApiClient\Model\Order\Items
 */
class Product extends AbstractModel
{
    /**
     * @var Amount $price
     */
    protected $price;

    /**
     * @var string $name the name of the product
     */
    protected $name;

    /**
     * @var string $sku the sku of the product
     */
    protected $sku;

    /**
     * @var int $quantity number of items of this type
     */
    protected $quantity;

    /**
     * @return Amount
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param Amount $price
     *
     * @return Product
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }


    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Product
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getSku()
    {
        return $this->sku;
    }

    /**
     * @param string $sku
     * @return Product
     */
    public function setSku($sku)
    {
        $this->sku = $sku;
        return $this;
    }

    /**
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param $quantity
     *
     * @return $this
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }
}
