<?php
/**
 * @see  https://developer.wepay.com/api/api-calls/account#modify
 */
namespace Omnipay\WePay\Account\Message\Request;

use Omnipay\WePay\Message\Request\AbstractRequest;
use Omnipay\WePay\Account\Message\Response\ModifyResponse;
use Omnipay\WePay\Utilities\LazyLoadParametersTrait;

class Modify extends AbstractRequest
{
    use LazyLoadParametersTrait;

    protected $accepted_parameters = [
        'account_id',
        'name',
        'description',
        'reference_id',
        'callback_uri',
        'rbits',
        'country_options',
        'fee_schedule_slot',
        'support_contact_number',
        'image_uri',
        'gaq_domains',
        'theme_object'
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
        return 'account/modify';
    }

    protected function createResponse($data, $headers = [], $code = null, $status_reason = '')
    {
        return $this->response = new ModifyResponse($this, $data, $headers, $code, $status_reason);
    }
}
