<?php

namespace PagaMasTarde\OrdersApiClient;

use PagaMasTarde\OrdersApiClient\Method\GetOrderMethod;

/**
 * Class OrdersApiClient
 *
 * @package PagaMasTarde/OrdersApiClient
 */
class OrdersApiClient
{
    /**
     * Private key for API calls
     *
     * @var string $privateKey
     */
    protected $privateKey;

    /**
     * Public key for API calls
     *
     * @var string $publicKey
     */
    protected $publicKey;

    /**
     * SandBox url should be specified here
     *
     * @var string $baseUri
     */
    protected $baseUri;

    /**
     * OrdersApiClient constructor.
     *
     * @param string $publicKey
     * @param string $privateKey
     * @param null   $baseUri
     */
    public function __construct($publicKey, $privateKey, $baseUri = null)
    {
        $this->publicKey = trim($publicKey);
        $this->privateKey = trim($privateKey);
        $this->baseUri = $baseUri;
    }

    public function getOrder($orderId)
    {
        $getOrderMethod = new GetOrderMethod($this->publicKey, $this->privateKey, $this->baseUri, $orderId);

        return $getOrderMethod;
    }
}
