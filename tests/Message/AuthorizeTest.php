<?php
namespace Omnipay\WePay\Message;

use Omnipay\WePay\Message\Request\Authorize;
use Omnipay\WePay\Message\Response\AuthorizeResponse;;
use Omnipay\WePay\Utilities\AbstractRequestTestCase;
use Omnipay\Common\Message\ResponseInterface;

class AuthorizeTest extends AbstractRequestTestCase
{
    protected $request = null;

    public function setUp()
    {
        $this->setRequest(new Authorize($this->getHttpClient(), $this->getHttpRequest()));
    }

    /**
     * Used for testing the instance of the response
     *
     * @return string
     */
    public function getResponseClass()
    {
        return AuthorizeResponse::class;
    }

    public function testParameters()
    {
        $tests = [
            "client_id" => 12345,
            "client_secret" => "asbasf2341",
            "credit_card_id" => 235810395803
        ];

        foreach ($tests as $key => $value) {
            $getter = 'get'.ucfirst($this->camelCase($key));
            $setter = 'set'.ucfirst($this->camelCase($key));

            $this->request->$setter($value);
            $this->assertSame($value, $this->request->$getter($key));
        }
    }

    public function testEndpoint()
    {
        // input endpoint here:
        $this->_testEndpoint('credit_card/authorize');
    }

    public function testResponse()
    {
        $this->setMockHttpResponse('AuthorizeSuccess.txt');
        $response = $this->getRequest()->send();

        $this->_testResponseInstanceOf($response);
    }

    public function testSendSuccess()
    {
        $this->_testSuccess('AuthorizeSuccess.txt');
    }

    public function testSendFailure()
    {
        $this->_testFailure('AuthorizeError.txt');
    }
}
