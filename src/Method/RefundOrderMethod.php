<?php

namespace PagaMasTarde\OrdersApiClient\Method;

use Httpful\Http;
use Httpful\Mime;
use Httpful\Request;
use Httpful\Response;
use PagaMasTarde\OrdersApiClient\Exception\ValidationException;
use PagaMasTarde\OrdersApiClient\Model\Order;

/**
 * Class RefundOrderMethod
 *
 * @package PagaMasTarde\OrdersApiClient\Method
 */
class RefundOrderMethod extends AbstractMethod
{
    /**
     * Get Order Endpoint
     */
    const ENDPOINT = '/orders';

    const REFUND_ENDPOINT = 'refunds';

    /**
     * @var string $orderId
     */
    protected $orderId;

    /**
     * @var Order\Refund
     */
    protected $refund;

    /**
     * @param string $orderId
     *
     * @return $this
     */
    public function setOrderId($orderId)
    {
        $this->orderId = $orderId;

        return $this;
    }

    /**
     * @param Order\Refund $refund
     *
     * @return $this
     */
    public function setRefund(Order\Refund $refund)
    {
        $this->refund = $refund;

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
        if ($this->refund instanceof Order\Refund && is_string($this->orderId)) {
            $this->prepareRequest();
            return $this->setResponse($this->request->send());
        }
        throw new ValidationException('Please set Refund Object and OrderId');
    }

    /**
     * @return bool|Order\Refund
     * @throws ValidationException
     */
    public function getRefund()
    {
        $response = $this->getResponse();
        if ($response instanceof Response) {
            $refund = new Order\Refund();
            $refund->import($this->getResponse()->body);
            return $refund;
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
                    $this->apiConfiguration->getBaseUri().
                    self::SLASH.
                    self::ENDPOINT.
                    self::SLASH.
                    $this->orderId.
                    self::SLASH.
                    self::REFUND_ENDPOINT
                )
                ->sendsType(Mime::JSON)
                ->body(json_encode($this->refund->export()))
            ;
        }
    }
}
