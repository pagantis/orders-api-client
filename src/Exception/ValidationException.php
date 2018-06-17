<?php

namespace PagaMasTarde\OrdersApiClient\Exception;

/**
 * Class ValidationException
 * @package PagaMasTarde\OrdersApiClient\Exception
 */
class ValidationException extends \Exception
{
    /**
     * Default Message
     */
    const MESSAGE = 'Provided data does not conform to business model or basic domain validation rules';

    /**
     * Default Code
     */
    const CODE = 0;

    /**
     * @var string
     */
    protected $message;

    /**
     * @var int
     */
    protected $code;

    /**
     * ValidationException constructor.
     *
     * @param string          $message
     * @param int             $code
     * @param \Throwable|null $previous
     */
    public function __construct($message = "", $code = 0, \Throwable $previous = null)
    {
        $this->message = empty($message) ? self::MESSAGE : $message;
        $this->code = empty($code) ? self::CODE : $code;
    }
}
