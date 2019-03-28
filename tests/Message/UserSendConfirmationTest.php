<?php

namespace Omnipay\WePay\Message;

use Omnipay\WePay\User\Message\Request\SendConfirmation;
use Omnipay\WePay\User\Message\Response\SendConfirmationResponse;
use Omnipay\WePay\Utilities\AbstractRequestTestCase;
use Omnipay\WePay\Utilities\TestLazyLoadDataTrait;
use Omnipay\Common\Helper;

class UserSendConfirmationTest extends AbstractRequestTestCase
{

    use TestLazyLoadDataTrait;

    public function setUp()
    {
        $this->setRequest(new SendConfirmation($this->getHttpClient(), $this->getHttpRequest()));
    }

    protected function getResponseClass()
    {
        return SendConfirmationResponse::Class;
    }

    protected function getRequestData()
    {
        return [
            'access_token'      => "STAGE_abcdefghijklmnopqrstuvwxyz1234567890",
            'email_message'     => "Welcome to the best application ever!",
            'email_subject'     => "You're one step closer to raising lots of money!",
            'email_button_text' => 'Click here to register'
        ];
    }

    public function testEndpoint()
    {
        $this->_testEndpoint('user/send_confirmation');
    }

    public function testSetRequestData()
    {
        $this->_testSetRequestData();
    }

    public function testSendSuccess()
    {
        $this->setMockHttpResponse('UserSendConfirmationSuccess.txt');
        $response = $this->getRequest()->send();

        $this->_testResponseInstanceOf($response);

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame("OK", $response->getStatusReason());
    }

    public function testSendFailure()
    {
        $this->setMockHttpResponse('UserSendConfirmationError.txt');
        $response = $this->getRequest()->send();

        $this->_testResponseInstanceOf($response);

        $this->assertFalse($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertSame(400, $response->getStatusCode());
        $this->assertSame("Bad Request", $response->getStatusReason());

        $this->assertNotEmpty($response->getError());
        $this->assertNotEmpty($response->getErrorDescription());
        $this->assertNotEmpty($response->getErrorCode());

    }
}
