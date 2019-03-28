<?php
/**
 * @see  https://developer.wepay.com/api/api-calls/account#create
 */
namespace Omnipay\WePay\Account\Message\Request;

use Omnipay\WePay\Message\Request\AbstractRequest;
use Omnipay\WePay\Account\Message\Response\CreateResponse;
use Omnipay\WePay\Utilities\LazyLoadParametersTrait;

class Create extends AbstractRequest
{
    use LazyLoadParametersTrait;

    protected $accepted_parameters = [
        'name',
        'description',
        'reference_id',
        'type',
        'callback_uri',
        'mcc',
        'country',
        'currencies',
        'rbits',
        'country_options',
        'fee_schedule_slot',
        'support_contact_number',
        'theme_object',
        'image_uri',
        'gaq_domains',
    ];

    /**
     * {@inheritdoc}
     */
    public function getData()
    {
        return $this->getLazyLoadedData();
    }

    public function getEndpoint()
    {
        return 'account/create';
    }

    protected function createResponse($data, $headers = [], $code = null, $status_reason = '')
    {
        return $this->response = new CreateResponse($this, $data, $headers, $code, $status_reason);
    }
}
