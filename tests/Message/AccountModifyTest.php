<?php

namespace Omnipay\WePay\Message;

use Omnipay\WePay\Account\Message\Request\Modify;
use Omnipay\WePay\Account\Message\Response\ModifyResponse;;
use Omnipay\WePay\Utilities\AbstractRequestTestCase;
use Omnipay\Common\Message\ResponseInterface;

class AccountModifyTest extends AbstractRequestTestCase
{
    public function setUp()
    {
        $this->setRequest(new Modify($this->getHttpClient(), $this->getHttpRequest()));
    }

    /**
     * Used for testing the instance of the response
     *
     * @see AbstractRequestTestCase::_testResponseInstanceOf
     * @return string
     */
    public function getResponseClass()
    {
        return ModifyResponse::class;
    }

    public function testEndpoint()
    {
        $this->_testEndpoint('account/modify');
    }

    public function testResponse()
    {
        $this->setMockHttpResponse('AccountModifySuccess.txt');
        $response = $this->getRequest()->send();

        $this->_testResponseInstanceOf($response);
    }

    public function testSendSuccess()
    {
        $this->_testSuccess('AccountModifySuccess.txt');
    }

    public function testSendFailure()
    {
        $this->_testFailure('AccountModifyError.txt');
    }
}
