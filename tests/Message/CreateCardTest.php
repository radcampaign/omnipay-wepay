<?php
namespace Omnipay\WePay\Message;

use Omnipay\WePay\Message\Request\CreateCard;
use Omnipay\WePay\Message\Response\CreateCardResponse;
use Omnipay\WePay\Utilities\AbstractRequestTestCase;
use Omnipay\Common\Message\ResponseInterface;
use Omnipay\Common\CreditCard;

class CreateCardTest extends AbstractRequestTestCase
{
    /**
     * Sets up our test
     */
    public function setUp()
    {
        $this->setRequest(new CreateCard($this->getHttpClient(), $this->getHttpRequest()));
    }

    /**
     * Used for testing the instance of the response
     *
     * @return string
     */
    public function getResponseClass()
    {
        return CreateCardResponse::class;
    }

    /**
     * Tests that the endpoints match
     *
     * @return void
     */
    public function testEndpoint()
    {
        // input endpoint here:
        $this->_testEndpoint('credit_card/create');
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

    /**
     * Use this to set test data
     *
     * @see AbstractRequestTest::setTestData()
     * @return array     associative array keyed by the parameter name and valued by the parameter value
     */
    protected function getTestData()
    {
        // use this to set test data
        return [];
    }

    /**
     * Tests that the response is the right instance
     *
     * @return void
     */
    public function testResponse()
    {
        $this->setMockHttpResponse('CreateCardSuccess.txt');
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
        $this->_testSuccess('CreateCardSuccess.txt');
    }

    /**
     * Tests that the response failed
     *
     * @return void
     */
    public function testSendFailure()
    {
        $this->_testFailure('CreateCardError.txt');
    }
}
