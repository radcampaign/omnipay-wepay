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
        $this->_testEndpoint('user/modify');
    }

    public function testResponse()
    {
        $this->setMockHttpResponse('UserModifySuccess.txt');
        $response = $this->getRequest()->send();
        $this->_testResponseInstanceOf($response);
    }

    public function testSendSuccess()
    {
        $test = 'http://hello.test/';
        $this->getRequest()->setCallbackUri($test);
        $response = $this->_testSuccess('UserModifySuccess.txt');
        $this->assertFalse($response->isRedirect());
        $this->assertSame($test, $response->getData('callback_uri'));
    }

    public function testSendFailure()
    {
        $response = $this->_testFailure('UserModifyError.txt');
    }
}
