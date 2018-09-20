<?php

namespace Test\PagaMasTarde\OrdersApiClient\Model\Order\Configuration;

use PagaMasTarde\OrdersApiClient\Model\Order\Configuration\Urls;
use Test\PagaMasTarde\OrdersApiClient\AbstractTest;

/**
 * Class UrlsTest
 * @package Test\PagaMasTarde\OrdersApiClient\Model\Order\Configuration
 */
class UrlsTest extends AbstractTest
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
     */
    public function testSetOk()
    {
        $urls = new Urls();
        $urls->setOk(null);
        $this->assertNull($urls->getOk());
        $urls->setOk(self::VALID_URL);
        $this->assertEquals(self::VALID_URL, $urls->getOk());
    }

    /**
     * testSetOk
     */
    public function testSetKo()
    {
        $urls = new Urls();
        $urls->setKo(null);
        $this->assertNull($urls->getKo());
        $urls->setKo(self::VALID_URL);
        $this->assertEquals(self::VALID_URL, $urls->getKo());
    }

    /**
     * testSetOk
     */
    public function testSetCancel()
    {
        $urls = new Urls();
        $urls->setCancel(null);
        $this->assertNull($urls->getCancel());
        $urls->setCancel(self::VALID_URL);
        $this->assertEquals(self::VALID_URL, $urls->getCancel());
    }

    /**
     * testSetOk
     */
    public function testSetNotificationCallback()
    {
        $urls = new Urls();
        $urls->setNotificationCallback(null);
        $this->assertNull($urls->getNotificationCallback());
        $urls->setNotificationCallback(self::VALID_URL);
        $this->assertEquals(self::VALID_URL, $urls->getNotificationCallback());
    }
}
