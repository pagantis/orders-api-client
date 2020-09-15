<?php

namespace Pagantis\OrdersApiClient\Model\Order;

use Pagantis\OrdersApiClient\Model\AbstractModel;

/**
 * Class Courier
 * @package Pagantis\OrdersApiClient\Model\Order
 */
class Courier extends AbstractModel
{
    /**
     * @var String $shippedAt The time at which the order was shipped, in ISO 8601 format.
     */
    protected $shippedAt;

    /**
     * @var string $name Courier name.
     */
    protected $name;

    /**
     * @var string $tracking Courier tracking locator.
     */
    protected $tracking;

    /**
     * @var string $priority Courier priority STANDARD|EXPRESS
     */
    protected $priority;

    /**
     * Not adding getters nor setters
     *
     * @deprecated
     */
    protected $truncated = false;

    /**
     * Configuration constructor.
     */
    public function __construct()
    {
        //No dependencies
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return Courier
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getTracking()
    {
        return $this->tracking;
    }

    /**
     * @param $tracking
     *
     * @return $this
     */
    public function setTracking($tracking)
    {
        $this->tracking = $tracking;

        return $this;
    }

    /**
     * @return string
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * @return string
     */
    public function getShippedAt()
    {
        return $this->shippedAt;
    }

    /**
     * @param string $shippedAt
     *
     * @return Courier
     */
    public function setShippedAt($shippedAt)
    {
        $this->shippedAt = $this->checkDateFormat($shippedAt);

        return $this;
    }

}
