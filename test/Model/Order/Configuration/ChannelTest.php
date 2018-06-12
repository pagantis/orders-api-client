<?php

namespace Test\PagaMasTarde\OrdersApiClient\Model\Order\Configuration;

use PagaMasTarde\OrdersApiClient\Model\Order\Configuration\Channel;
use PHPUnit\Framework\TestCase;

/**
 * Class ChannelTest
 * @package Test\PagaMasTarde\OrdersApiClient\Model\Order\Configuration
 */
class ChannelTest extends TestCase
{
    /**
     * Online type, for sales in the website
     */
    const ONLINE = 'ONLINE';

    /**
     * In store type, for sales in a physical store
     */
    const INSTORE = 'INSTORE';

    /**
     * Phonesale type, for sales made on the phone
     */
    const PHONESALE = 'PHONESALE';

    /**
     * testSetAssistedSale
     *
     * @expectedException \Exceptions\Data\ValidationException
     */
    public function testSetAssistedSale()
    {
        $channel = new Channel();
        $channel->setAssistedSale(null);
        $this->assertNull($channel->getAssistedSale());
        $channel->setAssistedSale(true);
        $this->assertTrue($channel->getAssistedSale());
        $channel->setAssistedSale('string');
    }

    /**
     * testSetType
     *
     * @expectedException \Exceptions\Data\ValidationException
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
        $channel->setType('string');
    }

    /**
     * testValidate
     *
     * @expectedException \Exceptions\Data\ValidationException
     *
     * @throws \ReflectionException
     */
    public function testValidate()
    {
        //AssistedCase
        $channel = new Channel();
        $channel->setType(Channel::INSTORE);
        $channel->setAssistedSale(true);
        $this->assertTrue($channel->validate());

        //All cases
        $channel->setAssistedSale(false);
        $reflectionClass = new \ReflectionClass(
            'PagaMasTarde\OrdersApiClient\Model\Order\Configuration\Channel'
        );
        $constants = $reflectionClass->getConstants();
        foreach ($constants as $constant) {
            $channel->setType($constant);
            $this->assertTrue($channel->validate());
        }

        //Failure
        $channel->setAssistedSale(true);
        $channel->setType(Channel::PHONESALE);
        $channel->validate();
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
