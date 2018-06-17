<?php

namespace PagaMasTarde\OrdersApiClient;

use Httpful\Exception\ConnectionErrorException;
use PagaMasTarde\OrdersApiClient\Method\ConfirmOrderMethod;
use PagaMasTarde\OrdersApiClient\Method\CreateOrderMethod;
use PagaMasTarde\OrdersApiClient\Method\GetOrderMethod;
use PagaMasTarde\OrdersApiClient\Method\ListOrdersMethod;
use PagaMasTarde\OrdersApiClient\Method\RefundOrderMethod;
use PagaMasTarde\OrdersApiClient\Method\UpsellOrderMethod;
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
     *
     * @throws ConnectionErrorException
     * @throws Exception\ValidationException
     */
    public function __construct($publicKey, $privateKey, $baseUri = null)
    {
        if (!function_exists("curl_init")) {
            throw new ConnectionErrorException("Curl module is not available on this system");
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
     * @param bool  $asJson
     *
     * @return bool|false|Order|string
     * @throws ConnectionErrorException
     * @throws Exception\HttpException
     * @throws Exception\ValidationException
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
     * @param      $orderId
     * @param bool $asJson
     *
     * @return bool|false|Order|string
     * @throws ConnectionErrorException
     * @throws Exception\HttpException
     * @throws Exception\ValidationException
     */
    public function getOrder($orderId, $asJson = false)
    {
        $getOrderMethod = new GetOrderMethod($this->apiConfiguration);
        $getOrderMethod->setOrderId($orderId);
        if ($asJson) {
            return $getOrderMethod->call()->getResponseAsJson();
        }

        return $getOrderMethod->call()->getOrder();
    }

    /**
     * listOrders
     *
     * @param array|null $queryString
     * @param bool       $asJson
     *
     * @return array|bool|string
     * @throws ConnectionErrorException
     * @throws Exception\HttpException
     * @throws Exception\ValidationException
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

    /**
     * @param      $orderId
     * @param bool $asJson
     *
     * @return bool|false|Order|string
     * @throws ConnectionErrorException
     * @throws Exception\HttpException
     * @throws Exception\ValidationException
     */
    public function confirmOrder($orderId, $asJson = false)
    {
        $confirmOrderMethod = new ConfirmOrderMethod($this->apiConfiguration);
        $confirmOrderMethod->setOrderId($orderId);
        if ($asJson) {
            return $confirmOrderMethod->call()->getResponseAsJson();
        }

        return $confirmOrderMethod->call()->getOrder();
    }

    /**
     * @param              $orderId
     * @param Order\Refund $refund
     * @param bool         $asJson
     *
     * @return bool|false|Order\Refund|string
     * @throws ConnectionErrorException
     * @throws Exception\HttpException
     * @throws Exception\ValidationException
     */
    public function refundOrder($orderId, Order\Refund $refund, $asJson = false)
    {
        $refundOrderMethod = new RefundOrderMethod($this->apiConfiguration);
        $refundOrderMethod->setOrderId($orderId);
        $refundOrderMethod->setRefund($refund);
        if ($asJson) {
            return $refundOrderMethod->call()->getResponseAsJson();
        }

        return $refundOrderMethod->call()->getRefund();
    }

    /**
     * @param              $orderId
     * @param Order\Upsell $upsell
     * @param bool         $asJson
     *
     * @return bool|false|Order\Upsell|string
     * @throws ConnectionErrorException
     * @throws Exception\HttpException
     * @throws Exception\ValidationException
     */
    public function upsellOrder($orderId, Order\Upsell $upsell, $asJson = false)
    {
        $refundOrderMethod = new UpsellOrderMethod($this->apiConfiguration);
        $refundOrderMethod->setOrderId($orderId);
        $refundOrderMethod->setUpsell($upsell);
        if ($asJson) {
            return $refundOrderMethod->call()->getResponseAsJson();
        }

        return $refundOrderMethod->call()->getUpsell();
    }
}
