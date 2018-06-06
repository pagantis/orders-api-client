<?php

namespace PagaMasTarde\OrdersApiClient\Method;

use Exceptions\Http\Server\ServerErrorException;
use Httpful\Http;
use Httpful\Mime;
use Httpful\Request;

/**
 * Class GetOrderMethod
 *
 * @package PagaMasTarde\OrdersApiClient\Method
 */
class GetOrderMethod extends AbstractMethod
{
    /**
     * Get Order Endpoint
     */
    const ENDPOINT = 'api/v1/orders';

    /**
     * @var string $orderId
     */
    protected $orderId;

    /**
     * @param string $orderId
     *
     * @return GetOrderMethod
     */
    public function setOrderId($orderId)
    {
        $this->orderId = $orderId;

        return $this;
    }

    /**
     * @return $this
     *
     * @throws \Httpful\Exception\ConnectionErrorException
     *
     * @throws ServerErrorException
     */
    public function call()
    {
        $response = Request::init()
            ->method(Http::GET)
            ->uri(
                $this->apiConfiguration->getBaseUri().
                self::SLASH.
                self::ENDPOINT.
                self::SLASH.
                $this->orderId
            )
            ->expects(Mime::JSON)
            ->authenticateWithBasic($this->apiConfiguration->getPublicKey(), $this->apiConfiguration->getPrivateKey())
            ->timeoutIn(5)
            ->send()
        ;

        if (!$response->hasErrors()) {
            $this->response = $response;
            return $this;
        }

        $this->parseHttpException($response->code);
    }
}
