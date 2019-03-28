<?php
/**
 * Payment gateway
 */
namespace Omnipay\WePay;

use Omnipay\Tests\GatewayTestCase;
use Omnipay\WePay\Requests\Router;
use Omnipay\WePay\Gateway;

class GatewayTest extends GatewayTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->gateway = new Gateway($this->getHttpClient(), $this->getHttpRequest());
    }

    /**
     * Test our singleton Router which determines our apiUrl for endpoints -
     * this is used throughout the requests
     * @return void
     */
    public function testRouter()
    {
        Router::setTestMode(false);
        $this->assertEquals(Router::LIVE_API_URL, Router::getApiUrl(), 'failed setting live api url');

        Router::setTestMode(true);
        $this->assertEquals(Router::TEST_API_URL, Router::getApiUrl(), 'failed setting test api url');
    }
}
