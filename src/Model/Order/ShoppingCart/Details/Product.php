<?php

namespace PagaMasTarde\OrdersApiClient\Model\Order\ShoppingCart\Details;

use Exceptions\Data\ValidationException;
use PagaMasTarde\OrdersApiClient\Model\AbstractModel;

/**
 * Class Product
 * @package PagaMasTarde\OrdersApiClient\Model\Order\ShoppingCart\Details
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
     */
    public function setAmount($amount)
    {
        if ($amount >= 1) {
            $this->amount = $amount;
            return $this;
        }

        throw new ValidationException('Amount has to be non zero natural number');
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
     */
    public function setQuantity($quantity)
    {
        if ($quantity >= 1) {
            $this->quantity = $quantity;
            return $this;
        }

        throw new ValidationException('Quantity has to be non zero natural number');
    }

    /**
     * Be sure to trigger setters in order to validate fields
     *
     * @return bool|true
     */
    public function validate()
    {
        $this->triggerSetters();

        if (!$this->getAmount() || !$this->getQuantity()) {
            throw new ValidationException('Amount and Quantity can not be empty');
        }

        return true;
    }
}
