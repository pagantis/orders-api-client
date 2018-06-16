<?php

namespace PagaMasTarde\OrdersApiClient\Method;

use Exceptions\Http\Server\ServerErrorException;
use Httpful\Http;
use Httpful\Request;
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
     * @return Order[] | false
     */
    public function getOrders()
    {
        $response = $this->getResponse();
        if ($response instanceof Response) {
            $responseBody = $response->body;
            $orders = array();
            foreach ($responseBody as $responseOrder) {
                $order = new Order();
                $order->import($responseOrder);
                $orders[] = $order;
            }

            return $orders;
        }

        return false;
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
        $this->prepareRequest();
        return $this->setResponse($this->request->send());
    }

    /**
     * prepareRequest
     */
    public function prepareRequest()
    {
        if (!$this->request instanceof Request) {
            $this->request = $this->getRequest()
                ->method(Http::GET)
                ->uri(
                    $this->apiConfiguration->getBaseUri().
                    self::SLASH.
                    self::ENDPOINT.
                    $this->addGetParameters($this->queryParameters)
                )
            ;
        }
    }
}
