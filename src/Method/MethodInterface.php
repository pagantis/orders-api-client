<?php

namespace PagaMasTarde\OrdersApiClient\Method;

use PagaMasTarde\OrdersApiClient\Model\AbstractModel;

/**
 * Interface MethodInterface
 * @package PagaMasTarde\OrdersApiClient\Method
 */
interface MethodInterface
{
    /**
     * All Api Methods should implement the function call
     *
     * @return AbstractModel
     */
    public function call();
}
