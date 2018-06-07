<?php

namespace PagaMasTarde\OrdersApiClient\Model\Order;

use PagaMasTarde\OrdersApiClient\Model\AbstractModel;
use PagaMasTarde\OrdersApiClient\Model\Order\Configuration\Channel;
use PagaMasTarde\OrdersApiClient\Model\Order\Configuration\Urls;

/**
 * Class Configuration
 * @package PagaMasTarde\OrdersApiClient\Model\Order
 */
class Configuration extends AbstractModel
{
    /**
     * @var Channel
     */
    protected $channel;

    /**
     * @var Urls
     */
    protected $urls;

    /**
     * Configuration constructor.
     */
    public function __construct()
    {
        $this->channel = new Channel();
        $this->urls = new Urls();
    }

    /**
     * @return Channel
     */
    public function getChannel()
    {
        return $this->channel;
    }

    /**
     * @return Urls
     */
    public function getUrls()
    {
        return $this->urls;
    }
}
