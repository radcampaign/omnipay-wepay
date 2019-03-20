<?php

namespace Omnipay\WePay\Message;

use Omnipay\WePay\User\Message\Request\Register;
use Omnipay\WePay\User\Message\Response\RegisterResponse;
use Omnipay\WePay\Utilities\AbstractRequestTestCase;
use Omnipay\WePay\Utilities\TestLazyLoadDataTrait;
use Omnipay\Common\Helper;

class UserRegisterTest extends AbstractRequestTestCase
{
    use TestLazyLoadDataTrait;

    protected $useTestData = true;

    public function setUp()
    {
        $this->setRequest(new Register($this->getHttpClient(), $this->getHttpRequest()));
    }

    protected function getResponseClass()
    {
        return RegisterResponse::class;
    }

    protected function getRequestData()
    {
        $data = [];
        $data['first_name'] = 'Josh';
        $data['last_name'] = 'Diamond';
        $data['email'] = 'myEmail@gmail.com';
        $data['tos_acceptance_time'] = time();
        $data['callback_uri'] = 'http://hello.test';
        $data['redirect_uri'] = 'http://myapp.test';
        $data['original_ip'] = '128.293.12.58';
        $data['original_device'] = "Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_6_6; en-US) AppleWebKit/534.13 (KHTML, like Gecko) Chrome/9.0.597.102 Safari/534.13";
        $data['scope'] = 'manage_accounts';
        return $data;
    }

    public function testSetRegistrationData()
    {
        $this->_testSetRequestData();
    }

    public function testSendSuccess()
    {
        $this->setMockHttpResponse('UserRegisterSuccess.txt');
        $response = $this->getRequest()->send();

        $this->_testResponseInstanceOf($response);

        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame("OK", $response->getStatusReason());
    }

    public function testSendFailure()
    {
        $this->setMockHttpResponse('UserRegisterError.txt');
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
