<?php

namespace PagaMasTarde\OrdersApiClient\Method;

use Exceptions\Data\ValidationException;
use Exceptions\Http\Server\ServerErrorException;
use Httpful\Http;
use Httpful\Mime;
use Httpful\Request;
use Httpful\Response;
use PagaMasTarde\OrdersApiClient\Model\Order;

/**
 * Class UpsellOrderMethod
 *
 * @package PagaMasTarde\OrdersApiClient\Method
 */
class UpsellOrderMethod extends AbstractMethod
{
    /**
     * Get Order Endpoint
     */
    const ENDPOINT = 'api/v1/orders';

    const UPSELL_ENDPOINT = 'upsell';

    /**
     * @var string $orderId
     */
    protected $orderId;

    /**
     * @var Order\Upsell
     */
    protected $upsell;

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
     * @param Order\Upsell $upsell
     *
     * @return $this
     */
    public function setUpsell(Order\Upsell $upsell)
    {
        $this->upsell = $upsell;

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
        if ($this->upsell instanceof Order\Upsell && is_string($this->orderId)) {
            $this->prepareRequest();
            return $this->setResponse($this->request->send());
        }
        throw new ValidationException('Please set Upsell Object and OrderId');
    }

    /**
     * @return Order\Upsell | false
     */
    public function getUpsell()
    {
        $response = $this->getResponse();
        if ($response instanceof Response) {
            $upsell = new Order\Upsell();
            $upsell->import($this->getResponse()->body);
            return $upsell;
        }

        return false;
    }

    /**
     * prepareRequest
     */
    protected function prepareRequest()
    {
        if (!$this->request instanceof Request) {
            $this->request = $this->getRequest()
                ->method(Http::PUT)
                ->uri(
                    $this->apiConfiguration->getBaseUri().
                    self::SLASH.
                    self::ENDPOINT.
                    self::SLASH.
                    $this->orderId.
                    self::SLASH.
                    self::UPSELL_ENDPOINT
                )
                ->sendsType(Mime::JSON)
                ->body(json_encode($this->upsell->export()))
            ;
        }
    }
}
