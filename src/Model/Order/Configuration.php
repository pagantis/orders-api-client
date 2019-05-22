<?php

namespace Pagantis\OrdersApiClient\Model\Order;

use Pagantis\OrdersApiClient\Model\AbstractModel;
use Pagantis\OrdersApiClient\Model\Order\Configuration\Channel;
use Pagantis\OrdersApiClient\Model\Order\Configuration\Urls;

/**
 * Class Configuration
 * @package Pagantis\OrdersApiClient\Model\Order
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
     * @var string purchaseCountry valid country for your merchant account: ES,IT,PT,FR
     */
    protected $purchaseCountry;

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

    /**
     * @return string
     */
    public function getPurchaseCountry()
    {
        return $this->purchaseCountry;
    }

    /**
     * @param Channel $channel
     *
     * @return Configuration
     */
    public function setChannel(Channel $channel)
    {
        $this->channel = $channel;

        return $this;
    }

    /**
     * @param Urls $urls
     *
     * @return Configuration
     */
    public function setUrls(Urls $urls)
    {
        $this->urls = $urls;

        return $this;
    }

    /**
     * @param string $purchaseCountry
     *
     * @return Configuration
     */
    public function setPurchaseCountry($purchaseCountry)
    {
        $upperPurchaseCountry = strtoupper($purchaseCountry);
        if (in_array($upperPurchaseCountry, array('IT','ES','PT','FR'))) {
            $this->purchaseCountry = $upperPurchaseCountry;
        } else {
            $this->purchaseCountry = null;
        }

        return $this;
    }
}
