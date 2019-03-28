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
        $this->_testEndpoint('user');
    }

    public function testResponse()
    {
        $this->setMockHttpResponse('UserFindSuccess.txt');
        $response = $this->getRequest()->send();

        $this->_testResponseInstanceOf($response);
    }

    public function testSendSuccess()
    {
        $response = $this->_testSuccess('UserFindSuccess.txt');
        $this->assertFalse($response->isRedirect());
    }

    public function testSendFailure()
    {
        $response = $this->_testFailure('UserFindError.txt');
    }
}
