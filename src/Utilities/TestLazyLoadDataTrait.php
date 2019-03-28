<?php
/**
 * A utility trait for helping us test our requests
 */
namespace Omnipay\WePay\Utilities;

use Omnipay\WePay\Utilities\HasTestDataTrait;
use Omnipay\Common\Helper;

trait TestLazyLoadDataTrait
{
    use HasTestDataTrait;

    /**
     * Gets the request data for testing
     *
     * @return array
     */
    // phpcs:ignore
    protected function _getTestRequestdata()
    {
        $data = [];

        if (property_exists($this, 'useTestData') && $this->useTestData === true) {
            $data = $this->getTestData();
        }

        if (!method_exists($this, 'getRequestData')) {
            return $data;
        }

        return array_merge($data, $this->getRequestData());
    }

    protected function setRequestData()
    {
        $data = $this->getRequestData();

        foreach ($data as $key => $value) {
            $setter = 'set' . ucfirst(Helper::camelCase($key));
            $this->getRequest()->$setter($value);
        }
    }

    // phpcs:ignore
    protected function _testSetRequestData()
    {
        $data = $this->getRequestData();

        $this->setRequestData();

        if (empty($data)) {
            trigger_error("Request data is empty - nothing to test", E_USER_WARNING);
        }

        foreach ($data as $key => $value) {
            $getter = 'get' . ucfirst(Helper::camelCase($key));
            $this->assertEquals($value, $this->getRequest()->$getter($value));
        }
    }
}
