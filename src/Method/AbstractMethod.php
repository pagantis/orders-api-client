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
            case BadRequestException::HTTP_CODE:
                throw new BadRequestException();
                break;
            case UnauthorizedException::HTTP_CODE:
                throw new UnauthorizedException();
                break;
            case ForbiddenException::HTTP_CODE:
                throw new ForbiddenException();
                break;
            case NotFoundException::HTTP_CODE:
                throw new NotFoundException();
                break;
            case MethodNotAllowedException::HTTP_CODE:
                throw new MethodNotAllowedException();
                break;
            case UnprocessableEntityException::HTTP_CODE:
                throw new UnprocessableEntityException();
                break;
            case InternalServerErrorException::HTTP_CODE:
                throw new InternalServerErrorException();
                break;
            case ServiceUnavailableException::HTTP_CODE:
                throw new ServiceUnavailableException();
                break;
            default:
                throw new InternalServerErrorException();
                break;
        }
    }
}
