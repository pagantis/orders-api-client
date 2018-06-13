<?php

namespace Test\PagaMasTarde\OrdersApiClient\Method;

use PagaMasTarde\OrdersApiClient\Model\ApiConfiguration;
use PHPUnit\Framework\TestCase;

abstract class AbstractTest extends TestCase
{
    /**
     * ApiConfiguration For testing Purpose
     *
     * @return ApiConfiguration
     */
    public function getTestApiConfiguration()
    {
        $apiConfiguration = new ApiConfiguration();
        $apiConfiguration
            ->setBaseUri(ApiConfiguration::SANDBOX_BASE_URI)
            ->setPublicKey('tk_9343d98abb794449a46ccf25')
            ->setPrivateKey('76efd4c7193840e0')
        ;

        return $apiConfiguration;
    }

    /**
     * ApiConfiguration For testing Purpose
     *
     * @return ApiConfiguration
     */
    public function get200ApiConfiguration()
    {
        $apiConfiguration = new ApiConfiguration();
        $apiConfiguration
            ->setBaseUri('https://httpstat.us/200?')
            ->setPublicKey('fake')
            ->setPrivateKey('fake')
        ;

        return $apiConfiguration;
    }

    /**
     * ApiConfiguration For testing Purpose
     *
     * @return ApiConfiguration
     */
    public function get404ApiConfiguration()
    {
        $apiConfiguration = new ApiConfiguration();
        $apiConfiguration
            ->setBaseUri('https://httpstat.us')
            ->setPublicKey('fake')
            ->setPrivateKey('fake')
        ;

        return $apiConfiguration;
    }
}
