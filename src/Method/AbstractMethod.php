<?php

namespace PagaMasTarde\OrdersApiClient\Method;

use Exceptions\Http\Client\BadRequestException;
use Exceptions\Http\Client\ForbiddenException;
use Exceptions\Http\Client\MethodNotAllowedException;
use Exceptions\Http\Client\NotFoundException;
use Exceptions\Http\Client\UnauthorizedException;
use Exceptions\Http\Client\UnprocessableEntityException;
use Exceptions\Http\Server\InternalServerErrorException;
use Exceptions\Http\Server\ServerErrorException;
use Exceptions\Http\Server\ServiceUnavailableException;
use Httpful\Mime;
use Httpful\Request;
use Httpful\Response;
use PagaMasTarde\OrdersApiClient\Model\ApiConfiguration;
use PagaMasTarde\OrdersApiClient\Model\Order;

/**
 * Class AbstractMethod
 *
 * @package PagaMasTarde\OrdersApiClient\Method
 */
abstract class AbstractMethod implements MethodInterface
{
    const SLASH = '/';

    /**
     * @var ApiConfiguration $apiConfiguration
     */
    protected $apiConfiguration;

    /**
     * @var Response
     */
    protected $response;

    /**
     * AbstractMethod constructor.
     *
     * @param ApiConfiguration $apiConfiguration
     */
    public function __construct(ApiConfiguration $apiConfiguration)
    {
        $this->apiConfiguration = $apiConfiguration;
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        return Request::init()
            ->expects(Mime::JSON)
            ->authenticateWithBasic($this->apiConfiguration->getPublicKey(), $this->apiConfiguration->getPrivateKey())
            ->timeoutIn(5)
        ;
    }

    /**
     * @return bool|Response
     */
    public function getResponse()
    {
        if ($this->response instanceof Response) {
            return $this->response;
        }

        return false;
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

    /**
     * @return bool|string
     */
    public function getResponseAsJson()
    {
        $response = $this->getResponse();
        if ($response instanceof Response) {
            return $response->raw_body;
        }

        return false;
    }

    /**
     * @param $array
     *
     * @return string
     */
    protected function addGetParameters($array)
    {
        $query = http_build_query(array_filter($array));

        return empty($query) ? '' : '?' . $query;
    }

    /**
     * @param $code
     *
     * @throws ServerErrorException
     */
    protected function parseHttpException($code)
    {
        switch ($code) {
            case 400:
                throw new BadRequestException();
                break;
            case 401:
                throw new UnauthorizedException();
                break;
            case 403:
                throw new ForbiddenException();
                break;
            case 404:
                throw new NotFoundException();
                break;
            case 405:
                throw new MethodNotAllowedException();
                break;
            case 422:
                throw new UnprocessableEntityException();
                break;
            case 500:
                throw new InternalServerErrorException();
                break;
            case 503:
                throw new ServiceUnavailableException();
                break;
            default:
                throw new InternalServerErrorException();
                break;
        }
    }
}
