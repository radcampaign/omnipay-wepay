<?php
/**
 * This is a abstract class for testing requests.
 * has some helpers for testing some basic things
 */
namespace Omnipay\WePay\Utilities;

use Omnipay\Tests\TestCase;
use Omnipay\Common\Message\ResponseInterface;
use Omnipay\Wepay\Message\Response\Generic;

abstract class AbstractRequestTestCase extends TestCase
{

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
    protected function _testResponseInstanceOf($response = null)
    {
        $this->assertNotNull($response);
        $this->assertInstanceOf($this->getResponseClass(), $response);
        $this->assertInstanceOf(ResponseInterface::Class, $response);
    }
}
