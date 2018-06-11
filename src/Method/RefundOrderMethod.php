<?php

namespace PagaMasTarde\OrdersApiClient\Method;

use Exceptions\Data\ValidationException;
use Exceptions\Http\Server\ServerErrorException;
use Httpful\Http;
use Httpful\Mime;
use Httpful\Response;
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
    const ENDPOINT = 'api/v1/orders';

    const REFUND_ENDPOINT = 'refund';

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
     * @return $this
     *
     * @throws \Httpful\Exception\ConnectionErrorException
     *
     * @throws ServerErrorException
     */
    public function call()
    {
        if ($this->refund instanceof Order\Refund && is_string($this->orderId)) {
            $response = $this->getRequest()
                ->method(Http::PUT)
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
                ->send()
            ;

            if (!$response->hasErrors()) {
                $this->response = $response;
                return $this;
            }

            return $this->parseHttpException($response->code);
        }
        throw new ValidationException('Please set Refund Object and OrderId');
    }

    /**
     * @return Order\Refund | false
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
}
