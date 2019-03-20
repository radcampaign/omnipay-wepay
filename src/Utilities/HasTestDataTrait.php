<?php
/**
 * For the test data in our tests
 */
namespace Omnipay\Wepay\Utilities;

trait HasTestDataTrait
{
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
}
