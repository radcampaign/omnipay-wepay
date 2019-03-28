<?php

namespace Omnipay\WePay\User\Message\Request;

use Omnipay\WePay\Message\Request\AbstractRequest;
use Omnipay\WePay\Utilities\LazyLoadParametersTrait;
use Omnipay\WePay\User\Message\Response\RegisterResponse;

class Register extends AbstractRequest
{
    use LazyLoadParametersTrait;

    protected $accepted_parameters = [
        'client_id',
        'client_secret',
        'email',
        'scope',
        'first_name',
        'last_name',
        'original_ip',
        'original_device',
        'tos_acceptance_time',
        'redirect_uri',
        'callback_uri',
    ];

    /**
     * {@inheritdoc}
     */
    public function getData()
    {
        return $this->getLazyLoadedData(['send_confirmation', 'access_token']);
    }

    public function getEndpoint()
    {
        return 'user/register';
    }

    public function send()
    {
        $resp = parent::send();

        return $resp;
    }

    protected function createResponse($data, $headers = [], $code, $status_reason = '')
    {
        return $this->response = new RegisterResponse($this, $data, $headers, $code, $status_reason);
    }
}
