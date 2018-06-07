<?php

namespace PagaMasTarde\OrdersApiClient\Method;

use Exceptions\Http\Server\ServerErrorException;
use Httpful\Http;
use Httpful\Response;
use PagaMasTarde\OrdersApiClient\Model\Order;

/**
 * Class ListOrdersMethod
 *
 * @package PagaMasTarde\OrdersApiClient\Method
 */
class ListOrdersMethod extends AbstractMethod
{
    /**
     * Get Order Endpoint
     */
    const ENDPOINT = 'api/v1/orders';

    /**
     * @var array $queryParameters
     */
    protected $queryParameters;

    /**
     * @param array $queryParameters
     *
     * @return $this
     */
    public function setQueryParameters(array $queryParameters)
    {
        $this->queryParameters = $queryParameters;

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
        $response = $this->getRequest()
            ->method(Http::GET)
            ->uri(
                $this->apiConfiguration->getBaseUri().
                self::SLASH.
                self::ENDPOINT.
                $this->addGetParameters($this->queryParameters)
            )
            ->send()
        ;

        if (!$response->hasErrors()) {
            $this->response = $response;
            return $this;
        }

        return $this->parseHttpException($response->code);
    }

    /**
     * @return Order[] | false
     */
    public function getOrders()
    {
        $response = $this->getResponse();
        if ($response instanceof Response) {
            //TODO map order from $response;
            return array();
        }

        return false;
    }
}
