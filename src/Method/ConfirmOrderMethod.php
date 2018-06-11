<?php

namespace PagaMasTarde\OrdersApiClient\Method;

use Exceptions\Data\ValidationException;
use Exceptions\Http\Server\ServerErrorException;
use Httpful\Http;
use Httpful\Response;
use PagaMasTarde\OrdersApiClient\Model\Order;

/**
 * Class ConfirmOrderMethod
 *
 * @package PagaMasTarde\OrdersApiClient\Method
 */
class ConfirmOrderMethod extends AbstractMethod
{
    /**
     * Get Order Endpoint
     */
    const ENDPOINT = 'api/v1/orders';

    const CONFIRM_ENDPOINT = 'confirm';

    /**
     * @var string $orderId
     */
    protected $orderId;

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
     * @return $this
     *
     * @throws \Httpful\Exception\ConnectionErrorException
     *
     * @throws ServerErrorException
     */
    public function call()
    {
        if (is_string($this->orderId)) {
            $response = $this->getRequest()
                ->method(Http::PUT)
                ->uri(
                    $this->apiConfiguration->getBaseUri().
                    self::SLASH.
                    self::ENDPOINT.
                    self::SLASH.
                    $this->orderId.
                    self::SLASH.
                    self::CONFIRM_ENDPOINT
                )
                ->send()
            ;

            if (!$response->hasErrors()) {
                $this->response = $response;
                return $this;
            }

            return $this->parseHttpException($response->code);
        }
        throw new ValidationException('Please set OrderId');
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
}
