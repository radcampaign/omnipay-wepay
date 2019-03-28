<?php
/**
 * Payment gateway
 */
namespace Omnipay\WePay;

use Omnipay\Tests\AccountGatewayTestCase;
use Omnipay\WePay\Account\Gateway;
use Omnipay\Common\Message\RequestInterface;
use OmniPay\Common\Helper;
use \Omnipay\WePay\Utilities\HasTestDataTrait;
## get our requests
use Omnipay\WePay\Account\Message\Request\Find;
use Omnipay\WePay\Account\Message\Request\Modify;
use Omnipay\WePay\Account\Message\Request\Create;
use Omnipay\WePay\Account\Message\Request\Delete;

class AccountGatewayTest extends AccountGatewayTestCase
{
    use HasTestDataTrait;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        parent::setUp();

        $this->gateway = new Gateway($this->getHttpClient(), $this->getHttpRequest());
    }

    public function testSetAccountId()
    {
        $test = 198765;
        $this->gateway->setAccountId($test);
        $this->assertSame($test, $this->gateway->getAccountId());
    }

     /**
     * Tets our find method
     *
     * @return void
     */
    public function testFind()
    {
        $request = $this->gateway->find();
        $this->assertInstanceOf(Find::class, $request);
    }

    public function testModify()
    {
        $request = $this->gateway->modify();
        $this->assertInstanceOf(Modify::class, $request);
        $this->_testLazyLoader($request, [
            'account_id' => 12345,
            'name' => "Example Account",
            'description' => 'This is a test modify description',
            'reference_id' => 'abc123',
            'callback_uri' => 'http://helloworld.com',
            'rbits' => [],
            'country_options' => [],
            'fee_schedule_slot' => 1,
            'image_uri' => 'http://helloworld.com/myimage.jpg',
            'gaq_domains' => [],
            'theme_object' => []
        ]);
    }

    public function testCreate()
    {
        $request = $this->gateway->create();
        $this->assertInstanceOf(Create::class, $request);
        $this->_testLazyLoader($request, [
            'name' => "Example Account",
            'description' => "Example Description",
            'reference_id' => "abc123",
            'type' => "nonprofit",
            'callback_uri' => "https://example.test",
            'mcc' => 7032,
            'country' => "US",
            'currencies' => ["USD"],
            'rbits' => [],
            'country_options' => [],
            'fee_schedule_slot' => 1,
            'support_contact_number' => [
                "country_code" => "+1",
                "phone_number" => "2022973842"
            ],
            'theme_object' => [
                "name" => "API THEME for API App: My Samle Application",
                "primary_color" => "FFFFFF",
                "secondary_color" => "000000",
                "background_color" => "004C64",
                "button_color" => "0084A0"
            ],
            'image_uri' => "https://example.test/image.png",
            'gaq_domains' => [],
        ]);
    }

    public function testDelete()
    {
        $request = $this->gateway->delete();
        $this->assertInstanceOf(Delete::class, $request);

        // test setting account id and reason
        $test = [
            'account_id' => 123456,
            'reason' => 'Do not want it anymore'
        ];

        $request->setAccountid($test['account_id']);
        $request->setReason($test['reason']);
        $this->assertSame($test['account_id'], $request->getAccountId());
        $this->assertSame($test['reason'], $request->getReason());

        // now test setting it through the construct
        $request = $this->gateway->delete($test);
        $this->assertSame($test['account_id'], $request->getAccountId());
        $this->assertSame($test['reason'], $request->getReason());
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
