<?php

namespace Pagantis\OrdersApiClient\Model\Order;

use Pagantis\OrdersApiClient\Model\AbstractModel;
use Pagantis\OrdersApiClient\Model\Order\Items\Product;

/**
 * Class Items
 * @package Pagantis\OrdersApiClient\Model\Order
 */
class Items extends AbstractModel
{
    /**
     * @var Product[]
     */
    protected $products;

    /**
     * Items constructor.
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
     * @return Items
     */
    public function addProduct(Product $product)
    {
        $this->products[] = $product;

        return $this;
    }
}
