<?php

namespace PagaMasTarde\OrdersApiClient;

use Exceptions\Operation\NotImplementedException;
use PagaMasTarde\OrdersApiClient\Method\CreateOrderMethod;
use PagaMasTarde\OrdersApiClient\Method\GetOrderMethod;
use PagaMasTarde\OrdersApiClient\Method\ListOrdersMethod;
use PagaMasTarde\OrdersApiClient\Model\ApiConfiguration;
use PagaMasTarde\OrdersApiClient\Model\Order;

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
     */
    public function __construct($publicKey, $privateKey, $baseUri = null)
    {
        if (!function_exists("curl_init")) {
            throw new NotImplementedException("Curl module is not available on this system");
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
     * @param Order $order
     * @param bool  $asJson return API JSON RESPONSE instead of the order object
     *
     * @return bool|false|Order|string
     * @throws \Httpful\Exception\ConnectionErrorException
     */
    public function createOrder(Order $order, $asJson = false)
    {
        $createOrderMethod = new CreateOrderMethod($this->apiConfiguration);
        $createOrderMethod->setOrder($order);
        if ($asJson) {
            return $createOrderMethod->call()->getResponseAsJson();
        }

        return $createOrderMethod->call()->getOrder();
    }

    /**
     * @param string    $orderId
     * @param bool      $asJson return API JSON RESPONSE instead of the order object
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

    /**
     * @param array $queryString
     * @param bool  $asJson return API JSON RESPONSE instead of the order object
     *
     * @return false|Model\Order|string
     *
     * @throws \Httpful\Exception\ConnectionErrorException
     */
    public function listOrders(array $queryString = null, $asJson = false)
    {
        $listOrdersMethod = new ListOrdersMethod($this->apiConfiguration);
        $listOrdersMethod->setQueryParameters($queryString);
        if ($asJson) {
            return $listOrdersMethod->call()->getResponseAsJson();
        }

        return $listOrdersMethod->call()->getOrders();
    }
}
