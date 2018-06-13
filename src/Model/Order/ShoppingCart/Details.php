<?php

namespace PagaMasTarde\OrdersApiClient\Model\Order\ShoppingCart;

use Exceptions\Data\ValidationException;
use PagaMasTarde\OrdersApiClient\Model\AbstractModel;
use PagaMasTarde\OrdersApiClient\Model\Order\ShoppingCart\Details\Product;

/**
 * Class Details
 * @package PagaMasTarde\OrdersApiClient\Model\Order\ShoppingCart
 */
class Details extends AbstractModel
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
     * Details constructor.
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
     * @return Details
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
     * @return Details
     */
    public function setShippingCost($shippingCost)
    {
        if ($shippingCost >= 0) {
            $this->shippingCost = $shippingCost;
            return $this;
        }

        throw new ValidationException('Shipping cost has to be natural number');
    }

    /**
     * Overwrite import to fill products correctly
     *
     * @param $object
     */
    public function import($object)
    {
        parent::import($object);
        $properties = get_object_vars($object);
        foreach ($properties as $key => $value) {
            if (is_array($value) && is_array($this->{$key}) && $key == 'products') {
                $this->products = array();
                foreach ($value as $product) {
                    $productObject = new Product();
                    $productObject->import($product);
                    $this->addProduct($productObject);
                }
            }
        }
    }

    /**
     * Trigger setters and double check that there is at least 1 product.
     *
     * @return bool|true
     */
    public function validate()
    {
        $this->triggerSetters();

        if (empty($this->products)) {
            throw new ValidationException('At least 1 product is expected');
        }

        foreach ($this->products as $product) {
            $product->validate();
        }

        return true;
    }
}
