<?php

namespace Test\PagaMasTarde\OrdersApiClient\Model;

use Faker\Factory;
use PagaMasTarde\OrdersApiClient\Model\ApiConfiguration;
use PHPUnit\Framework\TestCase;

/**
 * Class ApiConfigurationTest
 *
 * @package Test\PagaMasTarde\OrdersApiClient\Model
 */
class ApiConfigurationTest extends TestCase
{
    /**
     * Invalid URL
     */
    const VALID_URL = 'http://pagamastarde.com:8080/api/v1/orders?order=true';

    /**
     *  Valid URL
     */
    const INVALID_URL = '://pay.es';

    /**
     * Base URL for API calls
     */
    const BASE_URI = 'https://orders.pagamastarde.com';

    /**
     * Base URL for API calls
     */
    const SANDBOX_BASE_URI = 'https://orders-stg.pagamastarde.com';

    /**
     * testConstantsNotChange
     */
    public function testConstantsNotChange()
    {
        $this->assertEquals(self::BASE_URI, ApiConfiguration::BASE_URI);
        $this->assertEquals(self::SANDBOX_BASE_URI, ApiConfiguration::SANDBOX_BASE_URI);
    }

    /**
     * testSetBaseUrl
     *
     * @expectedException \PagaMasTarde\OrdersApiClient\Exception\ValidationException
     */
    public function testSetBaseUrl()
    {
        $apiConfiguration = new ApiConfiguration();
        $apiConfiguration->setBaseUri(self::VALID_URL);
        $this->assertEquals(self::VALID_URL, $apiConfiguration->getBaseUri());
        $apiConfiguration->setBaseUri(self::INVALID_URL);
    }

    /**
     * testValidate
     *
     * @throws \PagaMasTarde\OrdersApiClient\Exception\ValidationException
     */
    public function testValidate()
    {
        $faker = Factory::create();
        $apiConfiguration = new ApiConfiguration();
        $apiConfiguration->import((object) array('base_uri' => self::INVALID_URL));

        try {
            $apiConfiguration->validate();
            $this->assertTrue(false);
        } catch (\Exception $exception) {
            //Private and Public cannot be null
            $this->assertTrue(true);
        }

        $apiConfiguration
            ->setPrivateKey($faker->uuid)
            ->setPublicKey($faker->uuid)
        ;

        try {
            $apiConfiguration->validate();
            $this->assertTrue(false);
        } catch (\Exception $exception) {
            //Wrong BaseUri
            $this->assertTrue(true);
        }

        $apiConfiguration->setBaseUri(self::VALID_URL);
        $apiConfiguration->validate();
    }
}
