<?php

namespace Test\PagaMasTarde\OrdersApiClient\Model\Order\Configuration;

use PagaMasTarde\OrdersApiClient\Model\Order\Configuration\Urls;
use PHPUnit\Framework\TestCase;

/**
 * Class UrlsTest
 * @package Test\PagaMasTarde\OrdersApiClient\Model\Order\Configuration
 */
class UrlsTest extends TestCase
{
    /**
     * Invalid URL
     */
    const VALID_URL = 'http://pagamastarde.com:8080//orders?order=true';

    /**
     *  Valid URL
     */
    const INVALID_URL = '://pay.es';

    /**
     * testUrlValidate
     */
    public function testUrlValidate()
    {
        $this->assertTrue(Urls::urlValidate('https://pagamastarde.com'));
        $this->assertTrue(Urls::urlValidate('http://pagamastarde.com:8080//orders?order=true'));
        $this->assertFalse(Urls::urlValidate('://google.es'));
        $this->assertFalse(Urls::urlValidate('google.es'));
        $this->assertFalse(Urls::urlValidate('google'));
    }

    /**
     * testSetOk
     *
     * @expectedException \PagaMasTarde\OrdersApiClient\Exception\ValidationException
     */
    public function testValidate()
    {
        //Expected true:
        $urls = new Urls();
        $urls->setKo(self::VALID_URL);
        $urls->setOk(self::VALID_URL);
        $this->assertTrue($urls->validate());

        //Expected Failure:
        $urls = new Urls();
        $this->assertTrue($urls->validate());
    }

    /**
     * testSetOk
     *
     * @expectedException \PagaMasTarde\OrdersApiClient\Exception\ValidationException
     */
    public function testSetOk()
    {
        $urls = new Urls();
        $urls->setOk(null);
        $this->assertNull($urls->getOk());
        $urls->setOk(self::VALID_URL);
        $this->assertEquals(self::VALID_URL, $urls->getOk());
        $urls->setOk(self::INVALID_URL);
    }

    /**
     * testSetOk
     *
     * @expectedException \PagaMasTarde\OrdersApiClient\Exception\ValidationException
     */
    public function testSetKo()
    {
        $urls = new Urls();
        $urls->setKo(null);
        $this->assertNull($urls->getKo());
        $urls->setKo(self::VALID_URL);
        $this->assertEquals(self::VALID_URL, $urls->getKo());
        $urls->setKo(self::INVALID_URL);
    }

    /**
     * testSetOk
     *
     * @expectedException \PagaMasTarde\OrdersApiClient\Exception\ValidationException
     */
    public function testSetCancel()
    {
        $urls = new Urls();
        $urls->setCancel(null);
        $this->assertNull($urls->getCancel());
        $urls->setCancel(self::VALID_URL);
        $this->assertEquals(self::VALID_URL, $urls->getCancel());
        $urls->setCancel(self::INVALID_URL);
    }

    /**
     * testSetOk
     *
     * @expectedException \PagaMasTarde\OrdersApiClient\Exception\ValidationException
     */
    public function testSetNotificationCallback()
    {
        $urls = new Urls();
        $urls->setNotificationCallback(null);
        $this->assertNull($urls->getNotificationCallback());
        $urls->setNotificationCallback(self::VALID_URL);
        $this->assertEquals(self::VALID_URL, $urls->getNotificationCallback());
        $urls->setNotificationCallback(self::INVALID_URL);
    }
}
