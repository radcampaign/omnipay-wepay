<?php

namespace Omnipay\WePay\Message;

use Omnipay\WePay\User\Message\Request\Find;
use Omnipay\WePay\User\Message\Response\FindResponse;
use Omnipay\WePay\Utilities\AbstractRequestTestCase;
use Omnipay\Common\Message\ResponseInterface;

class UserFindTest extends AbstractRequestTestCase
{
    protected $request = null;

    public function setUp()
    {
        $this->setRequest(new Find($this->getHttpClient(), $this->getHttpRequest()));
    }

    protected function getResponseClass()
    {
        return FindResponse::class;
    }

    public function testEndpoint()
    {
        $this->assertSame('user', $this->getRequest()->getEndpoint());

        // test when testmode is off
        $this->getRequest()->setTestMode(false);
        $this->assertSame('https://wepayapi.com/v2/user', $this->getRequest()->buildEndpoint());

        // test when testMode gets turned back on
        $this->getRequest()->setTestMode(true);
        $this->assertSame('https://stage.wepayapi.com/v2/user', $this->getRequest()->buildEndpoint());
    }

    public function testSendSuccess()
    {
        $this->setMockHttpResponse('UserFindSuccess.txt');
        $response = $this->getRequest()->send();

        $this->_testResponseInstanceOf($response);

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame("OK", $response->getStatusReason());
    }

    public function testSendFailure()
    {
        $this->setMockHttpResponse('UserFindError.txt');
        $response = $this->getRequest()->send();

        $this->_testResponseInstanceOf($response);
        $this->assertFalse($response->isSuccessful());
        $this->assertSame(400, $response->getStatusCode());
        $this->assertSame("Bad Request", $response->getStatusReason());
    }
}
