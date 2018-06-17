<?php

namespace PagaMasTarde\OrdersApiClient\Method;

use Httpful\Mime;
use Httpful\Request;
use Httpful\Response;
use PagaMasTarde\OrdersApiClient\Exception\HttpException;
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
     * @var Request
     */
    protected $request;

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
        $query = '';
        if (is_array($array)) {
            $query = http_build_query(array_filter($array));
        }

        return empty($query) ? '' : '?' . $query;
    }

    /**
     * @param      $code
     * @param null $message
     *
     * @throws HttpException
     */
    protected function parseHttpException($code, $message = null)
    {
        switch ($code) {
            case HttpException::HTTP_BAD_REQUEST:
                throw new HttpException(HttpException::HTTP_BAD_REQUEST);
                break;
            case HttpException::HTTP_UNAUTHORIZED:
                throw new HttpException(HttpException::HTTP_UNAUTHORIZED);
                break;
            case HttpException::HTTP_FORBIDDEN:
                throw new HttpException(HttpException::HTTP_FORBIDDEN);
                break;
            case HttpException::HTTP_NOT_FOUND:
                throw new HttpException(HttpException::HTTP_NOT_FOUND);
                break;
            case HttpException::HTTP_METHOD_NOT_ALLOWED:
                throw new HttpException(HttpException::HTTP_METHOD_NOT_ALLOWED);
                break;
            case HttpException::HTTP_UNPROCESSABLE_ENTITY:
                throw new HttpException(HttpException::HTTP_UNPROCESSABLE_ENTITY);
                break;
            case HttpException::HTTP_INTERNAL_SERVER_ERROR:
                throw new HttpException(HttpException::HTTP_INTERNAL_SERVER_ERROR);
                break;
            case HttpException::HTTP_SERVICE_UNAVAILABLE:
                throw new HttpException(HttpException::HTTP_SERVICE_UNAVAILABLE);
                break;
            case HttpException::HTTP_CONFLICT:
                throw new HttpException(HttpException::HTTP_CONFLICT, $message);
                break;
            default:
                throw new HttpException(HttpException::HTTP_INTERNAL_SERVER_ERROR);
                break;
        }
    }

    /**
     * @return Request
     */
    protected function getRequest()
    {
        return Request::init()
            ->expects(Mime::JSON)
            ->authenticateWithBasic($this->apiConfiguration->getPublicKey(), $this->apiConfiguration->getPrivateKey())
            ->timeoutIn(5)
            ;
    }

    /**
     * @param Response $response
     *
     * @return $this
     * @throws HttpException
     */
    protected function setResponse(Response $response)
    {
        if (!$response->hasErrors()) {
            $this->response = $response;
            return $this;
        }

        return $this->parseHttpException($response->code, $response->raw_body);
    }
}
