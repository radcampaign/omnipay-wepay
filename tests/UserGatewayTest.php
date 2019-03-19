<?php
/**
 * Payment gateway
 */
namespace Omnipay\WePay;

include_once 'UsesEnvironmentVariablesTrait.php';

use Omnipay\Tests\GatewayTestCase;
use Omnipay\WePay\User\Gateway;
use Omnipay\WePay\User\Message\Request\Find;
use Omnipay\WePay\User\Message\Request\Modify;
use Omnipay\WePay\User\Message\Request\Register;
use Omnipay\Common\Message\RequestInterface;
use OmniPay\Common\Helper;

class UserGatewayTest extends GatewayTestCase
{
    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        parent::setUp();

        $this->gateway = new Gateway($this->getHttpClient(), $this->getHttpRequest());
    }

    /**
     * Retrieves test data for our tests
     *
     * @param  string $key  optional - pass a key to retrieve a single variable, if empty, it returns all of our test data
     *
     * @return string|array
     */
    protected function getTestData($key = '')
    {
        $testData = [
            'access_token' => 'STAGE_XYZ1234XYZ1234XYZ1234XYZ1234XYZ1234XYZ1234XYZ1234XYZ1234XYZ1234X',
            'client_id'    => '12345',
            'client_secret' => '12ab34cde7',
        ];

        if (empty($key)) {
            return $testData;
        }

        return $testData[$key] ?? null;
    }

    /**
     * Tets our find method
     *
     * @return void
     */
    public function testFind()
    {
        $test_access_token = $this->getTestData('access_token');
        $request = $this->gateway->find([
            'access_token' => $test_access_token,
        ]);
        $this->assertInstanceOf(Find::class, $request);
        $this->assertEquals($request->getAccessToken(), $test_access_token);
    }

    /**
     * Tests our modify method
     *
     * @return void
     */
    public function testModify()
    {
        $data = $this->getTestData();
        $data['callback_uri'] = 'https://hello.org';

        $request = $this->gateway->modify($data);
        $this->assertInstanceOf(Modify::class, $request);
        $this->assertEquals($request->getCallbackUri(), $data['callback_uri']);
    }

    /**
     * Tests our register request
     *
     * @return void
     */
    public function testRegister()
    {
        $request = $this->gateway->register();
        $this->assertInstanceOf(Register::class, $request);

        $data = $this->getTestData();
        $data['first_name'] = 'Josh';
        $data['last_name'] = 'Diamond';
        $data['email'] = 'myEmail@gmail.com';
        $data['tos_acceptance_time'] = time();
        $data['callback_uri'] = 'http://hello.test';
        $data['redirect_uri'] = 'http://myapp.test';
        $data['original_ip'] = '128.293.12.58';
        $data['original_device'] = 'laptop/desktop';

        $this->_testLazyLoader($request, $data);
    }

    /**
     * Tests our sendConfirmatio method
     *
     * @return void
     */
    public function testSendConfirmation()
    {
        $request = $this->gateway->sendConfirmation();
        $data = ['access_token' => $this->getTestData('access_token')];

        $data = array_merge($data, [
            'email_message' => 'Hey this is a message',
            'email_subject' => 'What a subject!?!',
            'email_button_text' => 'Click Me!',
        ]);

        $this->_testLazyLoader($request, $data);
    }

    /**
     * A helper function to test the requests that use the LazyLoadPrametersTrait
     * @param  RequestInterface $request
     * @param  array            $data    an associative array of data
     * @return void
     */
    protected function _testLazyLoader(RequestInterface $request, $data = [])
    {
        foreach ($data as $key => $value) {
            // test the setting of values
            $setMethod = 'set' . ucfirst(Helper::camelCase($key));
            $request->$setMethod($value);

            // now test that they can be retrieved
            $method = 'get' . ucfirst(Helper::camelCase($key));
            $this->assertEquals($request->$method($key), $value);
        }
    }
}
