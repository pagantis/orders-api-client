<?php

namespace PagaMasTarde\OrdersApiClient\Method;

use Exceptions\Http\Server\ServerErrorException;
use Httpful\Http;
use Httpful\Mime;
use Httpful\Response;
use PagaMasTarde\OrdersApiClient\Model\Order;

/**
 * Class CreateOrderMethod
 *
 * @package PagaMasTarde\OrdersApiClient\Method
 */
class CreateOrderMethod extends AbstractMethod
{
    /**
     * Get Order Endpoint
     */
    const ENDPOINT = 'api/v1/orders';

    /**
     * @var Order
     */
    protected $order;

    /**
     * @param Order $order
     *
     * @return $this
     */
    public function setOrder(Order $order)
    {
        $this->order = $order;

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
            ->method(Http::POST)
            ->uri(
                $this->apiConfiguration->getBaseUri().
                self::SLASH.
                self::ENDPOINT
            )
            ->sendsType(Mime::JSON)
            ->body(json_encode($this->order->export()))
            ->send()
        ;

        if (!$response->hasErrors()) {
            $this->response = $response;
            return $this;
        }

        return $this->parseHttpException($response->code);
    }

    /**
     * @return Order | false
     */
    public function getOrder()
    {
        $response = $this->getResponse();
        if ($response instanceof Response) {
            $order = new Order();
            //TODO map order from $response;
            return $order;
        }

        return false;
    }
}
