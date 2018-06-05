<?php

namespace PagaMasTarde\OrdersApiClient\Method;

/**
 * Class GetOrderMethod
 *
 * @package PagaMasTarde\OrdersApiClient\Method
 */
class GetOrderMethod extends AbstractMethod
{
    /**
     * @var string $orderId
     */
    protected $orderId;

    /**
     * @param $orderId
     *
     * @return $this
     */
    public function setOrderId($orderId)
    {
        $this->orderId = $orderId;

        return $this;
    }

    public function launch()
    {
        return new Order();
    }
}
