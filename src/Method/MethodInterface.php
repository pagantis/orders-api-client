<?php

namespace PagaMasTarde\OrdersApiClient\Method;

/**
 * Interface MethodInterface
 * @package PagaMasTarde\OrdersApiClient\Method
 */
interface MethodInterface
{
    /**
     * All Api Methods should implement the function call
     *
     * @return AbstractMethod
     */
    public function call();
}
