<?php

namespace Omnipay\WePay\Message;

use Omnipay\WePay\Account\Message\Request\Delete;
use Omnipay\WePay\Account\Message\Response\DeleteResponse;;
use Omnipay\WePay\Utilities\AbstractRequestTestCase;
use Omnipay\Common\Message\ResponseInterface;

class AccountDeleteTest extends AbstractRequestTestCase
{
    public function setUp()
    {
        $this->setRequest(new Delete($this->getHttpClient(), $this->getHttpRequest()));
    }

    /**
     * Used for testing the instance of the response
     *
     * @see AbstractRequestTestCase::_testResponseInstanceOf
     * @return string
     */
    public function getResponseClass()
    {
        return DeleteResponse::class;
    }

    public function testEndpoint()
    {
        $this->_testEndpoint('account/delete');
    }

     public function testResponse()
    {
        $this->setMockHttpResponse('AccountDeleteSuccess.txt');
        $response = $this->getRequest()->send();

        $this->_testResponseInstanceOf($response);
    }

    public function testSendSuccess()
    {
        $this->_testSuccess('AccountDeleteSuccess.txt');
    }

    public function testSendFailure()
    {
        $this->_testFailure('AccountDeleteError.txt');
    }
}
