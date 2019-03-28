<?php

namespace Omnipay\WePay\Message;

use Omnipay\WePay\Account\Message\Request\Create;
use Omnipay\WePay\Account\Message\Response\CreateResponse;;
use Omnipay\WePay\Utilities\AbstractRequestTestCase;
use Omnipay\Common\Message\ResponseInterface;

class AccountCreateTest extends AbstractRequestTestCase
{
    public function setUp()
    {
        $this->setRequest(new Create($this->getHttpClient(), $this->getHttpRequest()));
    }

    /**
     * Used for testing the instance of the response
     *
     * @see AbstractRequestTestCase::_testResponseInstanceOf
     * @return string
     */
    public function getResponseClass()
    {
        return CreateResponse::class;
    }

    public function testEndpoint()
    {
        $this->_testEndpoint('account/create');
    }

     public function testResponse()
    {
        $this->setMockHttpResponse('AccountCreateSuccess.txt');
        $response = $this->getRequest()->send();

        $this->_testResponseInstanceOf($response);
    }

    public function testSendSuccess()
    {
        $this->_testSuccess('AccountCreateSuccess.txt');
    }

    public function testSendFailure()
    {
        $this->_testFailure('AccountCreateError.txt');
    }
}
