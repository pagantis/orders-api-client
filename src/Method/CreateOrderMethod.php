<?php

namespace PagaMasTarde\OrdersApiClient\Method;

use Httpful\Http;
use Httpful\Mime;
use Httpful\Request;
use Httpful\Response;
use PagaMasTarde\OrdersApiClient\Exception\ValidationException;
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
    const ENDPOINT = '/orders';

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
     * @return $this|AbstractMethod
     * @throws ValidationException
     * @throws \Httpful\Exception\ConnectionErrorException
     * @throws \PagaMasTarde\OrdersApiClient\Exception\HttpException
     */
    public function call()
    {
        if ($this->order instanceof Order) {
            $this->prepareRequest();
            return $this->setResponse($this->request->send());
        }
        throw new ValidationException('Please Set Order');
    }

    /**
     * @return bool|Order
     * @throws ValidationException
     */
    public function getOrder()
    {
        $response = $this->getResponse();
        if ($response instanceof Response) {
            $order = new Order();
            $order->import($this->getResponse()->body);
            return $order;
        }

        return false;
    }

    /**
     * prepareRequest
     *
     * @throws ValidationException
     */
    protected function prepareRequest()
    {
        if (!$this->request instanceof Request) {
            $this->request = $this->getRequest()
                ->method(Http::POST)
                ->uri(
                    $this->apiConfiguration->getBaseUri() .
                    self::SLASH .
                    self::ENDPOINT
                )
                ->sendsType(Mime::JSON)
                ->body(json_encode($this->order->export()))
            ;
        }
    }
}
