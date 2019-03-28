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

    public function testEndpoint()
    {
        $this->_testEndpoint('user/register');
    }

    public function testSetRegistrationData()
    {
        $this->_testSetRequestData();
    }

    public function testSendSuccess()
    {
        $response = $this->_testSuccess('UserRegisterSuccess.txt');
        $this->assertFalse($response->isRedirect());
    }

    public function testSendFailure()
    {
        $response = $this->_testFailure('UserRegisterError.txt');
    }
}
