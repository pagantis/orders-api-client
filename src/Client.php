<?php

namespace PagaMasTarde\OrdersApiClient;

use PagaMasTarde\OrdersApiClient\Method\GetOrderMethod;
use PagaMasTarde\OrdersApiClient\Exception\ClientException;
use PagaMasTarde\OrdersApiClient\Model\ApiConfiguration;

/**
 * Class Client
 *
 * @package PagaMasTarde/OrdersApiClient
 */
class Client
{
    /**
     * @var ApiConfiguration
     */
    protected $apiConfiguration;

    /**
     * Client constructor.
     *
     * @param      $publicKey
     * @param      $privateKey
     * @param null $baseUri
     *
     * @throws ClientException
     *
     * @throws Exception\UrlException
     */
    public function __construct($publicKey, $privateKey, $baseUri = null)
    {
        if (!function_exists("curl_init")) {
            throw new ClientException("Curl module is not available on this system");
        }

        $apiConfiguration = new ApiConfiguration();
        $apiConfiguration
            ->setBaseUri($baseUri ? $baseUri : ApiConfiguration::BASE_URI)
            ->setPrivateKey($privateKey)
            ->setPublicKey($publicKey)
        ;
        $this->apiConfiguration = $apiConfiguration;
    }

    /**
     * @param string $orderId
     * @param bool $asJson return API JSON RESPONSE instead of the order object
     *
     * @return false|Model\Order|string
     *
     * @throws \Httpful\Exception\ConnectionErrorException
     */
    public function getOrderById($orderId, $asJson = false)
    {
        $getOrderMethod = new GetOrderMethod($this->apiConfiguration);
        $getOrderMethod->setOrderId($orderId);
        if ($asJson) {
            return $getOrderMethod->call()->getResponseAsJson();
        }

        return $getOrderMethod->call()->getOrder();
    }
}
