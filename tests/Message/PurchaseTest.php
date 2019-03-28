<?php
namespace Omnipay\WePay\Message;

use Omnipay\WePay\Message\Request\Purchase;
use Omnipay\WePay\Message\Response\PurchaseResponse;
use Omnipay\WePay\Utilities\AbstractRequestTestCase;
use Omnipay\Common\Message\ResponseInterface;
use Omnipay\WePay\Utilities\TestExceptionsTrait;

use Omnipay\WePay\Models\RequestStructures\CreditCard;
use Omnipay\WePay\Models\RequestStructures\PaymentMethod;
use Omnipay\WePay\Models\RequestStructures\HostedCheckout;

class PurchaseTest extends AbstractRequestTestCase
{
    /**
     * Sets up our test
     */
    public function setUp()
    {
        $this->setRequest(new Purchase($this->getHttpClient(), $this->getHttpRequest()));
    }

    /**
     * Used for testing the instance of the response
     *
     * @return string
     */
    public function getResponseClass()
    {
        return PurchaseResponse::class;
    }

    /**
     * Tests that the endpoints match
     *
     * @return void
     */
    public function testEndpoint()
    {
        // input endpoint here:
        $this->_testEndpoint('checkout/create');
    }

    /**
     * Tests that the parameters needed for a request
     * can be set and get
     *
     * @return void
     */
    public function testParameters()
    {
        // put your tests here
        $this->assertTrue(true);
    }

    protected function getTestData()
    {
        return [
            'account_id' => 1234567,
            'description' => "This is a great short description",
            'type' => "donation",
            'amount' => 13.30,
            'currency' => "USD",
        ];
    }

    /**
     * Tests that validate will throw an InvalidRequestException
     *
     * @return void
     */
    public function testValidate()
    {
        $this->expectInvalidRequestException();

        $this->setMockHttpResponse('PurchaseSuccess.txt');
        $response = $this->getRequest()->validate();
    }

    /**
     * Tests that the response is the right instance
     *
     * @return void
     */
    public function testResponse()
    {
        $this->setMockHttpResponse('PurchaseSuccess.txt');
        $response = $this->sendRequestWithData();

        $this->_testResponseInstanceOf($response);
    }

    /**
     * Tests that the response was a success
     *
     * @return void
     */
    public function testSendSuccess()
    {
        $this->_testSuccess('PurchaseSuccess.txt');
    }

    /**
     * Tests that the response failed
     *
     * @return void
     */
    public function testSendFailure()
    {
        $this->_testFailure('PurchaseError.txt');
    }

    public function testData()
    {
        $this->setTestData();
        $request = $this->getRequest();

        $data = $request->getData();
        $this->assertTrue(is_array($data), "Request data is not an array");

        // without a token, the request should be a HostedCheckout
        $this->assertArrayHasKey('hosted_checkout', $data);
        $this->assertInstanceOf(HostedCheckout::class, $data['hosted_checkout']);

        // setting the token should change the request to a credit_card output
        $token = 12345;
        $request->setToken($token);
        $data = $request->getData();

        $this->assertArrayHasKey('payment_method', $data);
        $this->assertInstanceOf(PaymentMethod::class, $data['payment_method']);

        $payment_method = $data['payment_method'];
        $this->assertArrayHasKey('credit_card', $payment_method->toArray());
        $this->assertInstanceOf(CreditCard::class, $payment_method->credit_card);

        $this->assertSame($token, $payment_method->credit_card->id);
    }
}
