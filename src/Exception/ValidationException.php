<?php

namespace PagaMasTarde\OrdersApiClient\Exception;

/**
 * Class HttpException
 * @package PagaMasTarde\OrdersApiClient\Exception
 */
class HttpException extends \Exception
{
    /**
     * List of additional headers
     *
     * @var array
     */
    private $headers = array();

    /**
     * Body message
     *
     * @var string
     */
    private $body = '';

    /**
     * List of HTTP status codes USED
     *
     * @var array
     */
    private $status = array(
        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        409 => 'Conflict',
        422 => 'Unprocessable Entity',
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
    );

    /**
     * @param int[optional]    $statusCode   If NULL will use 500 as default
     * @param string[optional] $statusPhrase If NULL will use the default status phrase
     * @param array[optional]  $headers      List of additional headers
     */
    public function __construct($statusCode = 500, $statusPhrase = null, array $headers = array())
    {
        if (null === $statusPhrase && isset($this->status[$statusCode])) {
            $statusPhrase = $this->status[$statusCode];
        }
        parent::__construct($statusPhrase, $statusCode);

        $header  = sprintf('HTTP/1.1 %d %s', $statusCode, $statusPhrase);

        $this->addHeader($header);
        $this->addHeaders($headers);
    }

    /**
     * Returns the list of additional headers
     *
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @param string $header
     *
     * @return self
     */
    public function addHeader($header)
    {
        $this->headers[] = $header;

        return $this;
    }

    /**
     * @param array $headers
     *
     * @return self
     */
    public function addHeaders(array $headers)
    {
        foreach ($headers as $key => $header) {
            if (!is_int($key)) {
                $header = $key.': '.$header;
            }

            $this->addHeader($header);
        }

        return $this;
    }

    /**
     * Return the body message.
     *
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Define a body message.
     *
     * @param string $body
     *
     * @return self
     */
    public function setBody($body)
    {
        $this->body = (string) $body;

        return $this;
    }
}