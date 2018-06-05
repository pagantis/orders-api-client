<?php

namespace PagaMasTarde\OrdersApiClient\Model;

use PagaMasTarde\OrdersApiClient\Exception\ProductException;

/**
 * Class Product
 * @package PagaMasTarde\OrdersApiClient\Model
 */
class Product extends AbstractModel
{
    /**
     * @var int $amount amount in cents of a product
     */
    protected $amount;

    /**
     * @var string $description the description of the product, normally name is enough
     */
    protected $description;

    /**
     * @var int $quantity number of items of this type
     */
    protected $quantity;

    /**
     * @return int
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param $amount
     *
     * @return $this
     *
     * @throws ProductException
     */
    public function setAmount($amount)
    {
        if ($amount >= 1 && is_int($amount)) {
            $this->amount = $amount;
            return $this;
        }

        throw new ProductException('Amount has to be non zero natural number');
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return Product
     */
    public function setDescription($description)
    {
        $this->description = $description;
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
     *
     * @throws ProductException
     */
    public function setQuantity($quantity)
    {
        if ($quantity >= 0 && is_int($quantity)) {
            $this->quantity = $quantity;
            return $this;
        }

        throw new ProductException('Quantity has to be non zero natural number');
    }
}
