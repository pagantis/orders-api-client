<?php

namespace Test\PagaMasTarde\OrdersApiClient\Model\Order\Configuration;

use PagaMasTarde\OrdersApiClient\Model\Order\Configuration\Channel;
use Test\PagaMasTarde\OrdersApiClient\AbstractTest;

/**
 * Class ChannelTest
 * @package Test\PagaMasTarde\OrdersApiClient\Model\Order\Configuration
 */
class ChannelTest extends AbstractTest
{
    /**
     * Online type, for sales in the website
     */
    const ONLINE = 'ONLINE';

    /**
     * In store type, for sales in a physical store
     */
    const INSTORE = 'IN_STORE';

    /**
     * Phonesale type, for sales made on the phone
     */
    const PHONESALE = 'PHONE';

    /**
     * testSetAssistedSale
     */
    public function testSetAssistedSale()
    {
        $channel = new Channel();
        $channel->setAssistedSale(null);
        $this->assertNull($channel->getAssistedSale());
        $channel->setAssistedSale(true);
        $this->assertTrue($channel->getAssistedSale());
    }

    /**
     * testSetType
     *
     * @throws \ReflectionException
     */
    public function testSetType()
    {
        $channel = new Channel();
        $reflectionClass = new \ReflectionClass(
            'PagaMasTarde\OrdersApiClient\Model\Order\Configuration\Channel'
        );
        $constants = $reflectionClass->getConstants();
        foreach ($constants as $constant) {
            $channel->setType($constant);
            $this->assertEquals($constant, $channel->getType());
        }

        $channel->setType(null);
        $this->assertNull($channel->getType());
    }

    /**
     * testConstantsNotChange
     *
     * @throws \ReflectionException
     */
    public function testConstantsNotChange()
    {
        $reflectionClass = new \ReflectionClass(
            'PagaMasTarde\OrdersApiClient\Model\Order\Configuration\Channel'
        );
        $channelConstants = $reflectionClass->getConstants();

        $reflectionClass = new \ReflectionClass(__CLASS__);
        $testChannelConstants = $reflectionClass->getConstants();

        $this->assertSame($testChannelConstants, $channelConstants);
    }
}
