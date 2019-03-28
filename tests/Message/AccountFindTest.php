<?php

namespace Omnipay\WePay\Message;

use Omnipay\WePay\Account\Message\Request\Find;
use Omnipay\WePay\Account\Message\Response\FindResponse;;
use Omnipay\WePay\Utilities\AbstractRequestTestCase;
use Omnipay\Common\Message\ResponseInterface;

class AccountFindTest extends AbstractRequestTestCase
{
    protected $request = null;

    public function setUp()
    {
        $this->setRequest(new Find($this->getHttpClient(), $this->getHttpRequest()));
    }

    /**
     * Used for testing the instance of the response
     *
     * @return string
     */
    public function getResponseClass()
    {
        return FindResponse::class;
    }

    public function testEndpoint()
    {
        $this->_testEndpoint('account');
    }

    public function testResponse()
    {
        $this->setMockHttpResponse('AccountFindSuccess.txt');
        $response = $this->getRequest()->send();

        $this->_testResponseInstanceOf($response);
    }

    public function testSendSuccess()
    {
        $this->_testSuccess('AccountFindSuccess.txt');
    }

    public function testSendFailure()
    {
        $this->_testFailure('AccountFindError.txt');
    }
}
