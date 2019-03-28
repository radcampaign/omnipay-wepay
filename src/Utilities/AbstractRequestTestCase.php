<?php
/**
 * This is a abstract class for testing requests.
 * has some helpers for testing some basic things
 */
namespace Omnipay\WePay\Utilities;

use Omnipay\Tests\TestCase;
use Omnipay\Common\Message\ResponseInterface;
use Omnipay\Wepay\Message\Response\Generic;
use Omnipay\Common\Helper;

abstract class AbstractRequestTestCase extends TestCase
{
    /**
     * Import our exceptExceptions functions
     */
    use TestExceptionsTrait;

    protected $request = null;

    protected function getRequest()
    {
        return $this->request;
    }

    protected function setRequest($request = null)
    {
        $this->request = $request;
        return $this;
    }

    /**
     * We need a way of getting the response class so taht we
     * can pass it to $this->assertInstanceOf(...)
     *
     * @return string
     */
    protected function getResponseClass()
    {
        return Generic::class;
    }

    /**
     * This tests that the response is not null and has some classes
     * that responses should have
     *
     * @param  null|RequestInterface $response
     * @return void
     */
    // phpcs:ignore
    protected function _testResponseInstanceOf($response = null)
    {
        $this->assertNotNull($response);
        $this->assertInstanceOf($this->getResponseClass(), $response);
        $this->assertInstanceOf(ResponseInterface::Class, $response);
    }

    /**
     * This test helps us test the enpoint of a request - makes sure our router is working
     *
     * @param  string $endpoint  the shortname of the endpoint - i.e. user
     * @return void
     */
    // phpcs:ignore
    protected function _testEndpoint($endpoint = '')
    {
        $this->assertSame($endpoint, $this->getRequest()->getEndpoint());

        $this->getRequest()->setTestMode(false);
        $this->assertSame('https://wepayapi.com/v2/' . $endpoint, $this->getRequest()->buildEndpoint());

        // test when testMode gets turned back on
        $this->getRequest()->setTestMode(true);
        $this->assertSame('https://stage.wepayapi.com/v2/' . $endpoint, $this->getRequest()->buildEndpoint());
    }

    // phpcs:ignore
    protected function _testSuccess($mock = '')
    {
        $this->setMockHttpResponse($mock);
        $response = $this->sendRequestWithData();

        $this->assertTrue($response->isSuccessful());
        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame("OK", $response->getStatusReason());

        $this->assertNull($response->getError());
        $this->assertNull($response->getErrorDescription());
        $this->assertNull($response->getErrorCode());

        return $response;
    }

    // phpcs:ignore
    protected function _testFailure($mock = '')
    {
        $this->setMockHttpResponse($mock);
        $response = $this->sendRequestWithData();

        $this->assertFalse($response->isSuccessful());
        $this->assertSame(400, $response->getStatusCode());
        $this->assertSame("Bad Request", $response->getStatusReason());

        $this->assertNotNull($response->getError());
        $this->assertNotNull($response->getErrorDescription());
        $this->assertNotNull($response->getErrorCode());

        return $response;
    }

    /**
     * Helper for setting test data
     */
    protected function setTestData()
    {
        if (!method_exists($this, 'getTestData')) {
            return;
        }

        $test_data = $this->getTestData();
        foreach ($test_data as $key => $value) {
            $setter = 'set'.ucfirst(Helper::camelCase($key));
            $this->getRequest()->$setter($value);
        }
    }

    /**
     * Sets test data and then sends the request Sends the request
     * @return ResponseInterface
     */
    protected function sendRequestWithData()
    {
        $this->setTestData();
        return $this->getRequest()->send();
    }
}
