<?php
/**
 * @see https://developer.wepay.com/api/api-calls/account#update
 */
namespace Omnipay\WePay\Account\Message\Request;

use Omnipay\WePay\Message\Request\AbstractRequest;
use Omnipay\WePay\Account\Message\Response\GetUpdateUriResponse;
use Omnipay\WePay\Utilities\LazyLoadParametersTrait;

class GetUpdateUri extends AbstractRequest
{
    use LazyLoadParametersTrait;

    protected $accepted_parameters = [
        'account_id',
        'mode',
        'redirect_uri',
        'prefill_info'
    ];

    /**
     * {@inheritdoc}
     */
    public function getData()
    {
        $ret = [];
        $data = $this->getLazyLoadedData();
        // we don't want to send data on a modify request
        // that may not have been set
        foreach ($data as $key => $value) {
            if (!is_null($value)) {
                $ret[$key] = $value;
            }
        }

        return $ret;
    }

    public function getEndpoint()
    {
        return 'account/get_update_uri';
    }

    protected function createResponse($data, $headers = [], $code = null, $status_reason = '')
    {
        return $this->response = new GetUpdateUriResponse($this, $data, $headers, $code, $status_reason);
    }
}
