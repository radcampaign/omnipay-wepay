<?php

namespace Omnipay\WePay\Message;

use Omnipay\WePay\User\Message\Request\Modify;
use Omnipay\WePay\User\Message\Response\ModifyResponse;
use Omnipay\WePay\Utilities\AbstractRequestTestCase;

class UserModifyTest extends AbstractRequestTestCase
{
    protected $request = null;

    public function setUp()
    {
        $this->setRequest(new Modify($this->getHttpClient(), $this->getHttpRequest()));
    }

    protected function getResponseClass()
    {
        return ModifyResponse::class;
    }

    public function testSetCallbackUri()
    {
        $test = 'http://hello.test/';
        $this->getRequest()->setCallbackUri($test);
        $this->assertSame($test, $this->getRequest()->getCallbackUri());
    }

    public function testEndpoint()
    {
        $this->assertSame('user/modify', $this->getRequest()->getEndpoint());

        $this->getRequest()->setTestMode(false);
        $this->assertSame('https://wepayapi.com/v2/user/modify', $this->getRequest()->buildEndpoint());

        // test when testMode gets turned back on
        $this->getRequest()->setTestMode(true);
        $this->assertSame('https://stage.wepayapi.com/v2/user/modify', $this->getRequest()->buildEndpoint());
    }

    public function testSendSuccess()
    {
        $this->setMockHttpResponse('UserModifySuccess.txt');

        $test = 'http://hello.test/';
        $this->getRequest()->setCallbackUri($test);
        $response = $this->getRequest()->send();

        $this->_testResponseInstanceOf($response);

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame("OK", $response->getStatusReason());
    }

    public function testSendFailure()
    {
        $this->setMockHttpResponse('UserModifyError.txt');
        $response = $this->getRequest()->send();

        $this->_testResponseInstanceOf($response);

        $this->assertFalse($response->isSuccessful());
        $this->assertSame(400, $response->getStatusCode());
        $this->assertSame("Bad Request", $response->getStatusReason());
    }
}
