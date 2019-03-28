<?php

namespace Omnipay\WePay\Message;

use Omnipay\WePay\Account\Message\Request\GetUpdateUri;
use Omnipay\WePay\Account\Message\Response\GetUpdateUriResponse;
use Omnipay\WePay\Utilities\AbstractRequestTestCase;
use Omnipay\Common\Message\ResponseInterface;

class AccountGetUpdateUriTest extends AbstractRequestTestCase
{
    public function setUp()
    {
        $this->setRequest(new GetUpdateUri($this->getHttpClient(), $this->getHttpRequest()));
    }

    /**
     * Used for testing the instance of the response
     *
     * @see AbstractRequestTestCase::_testResponseInstanceOf
     * @return string
     */
    public function getResponseClass()
    {
        return GetUpdateUriResponse::class;
    }

    public function testEndpoint()
    {
        $this->_testEndpoint('account/get_update_uri');
    }

     public function testResponse()
    {
        $this->setMockHttpResponse('AccountGetUpdateUriSuccess.txt');
        $response = $this->getRequest()->send();

        $this->_testResponseInstanceOf($response);
    }

    public function testSendSuccess()
    {
        $this->_testSuccess('AccountGetUpdateUriSuccess.txt');
    }

    public function testSendFailure()
    {
        $this->_testFailure('AccountGetUpdateUriError.txt');
    }
}
