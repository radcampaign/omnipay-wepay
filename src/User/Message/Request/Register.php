<?php

namespace Omnipay\WePay\User\Message\Request;

use Omnipay\WePay\Message\Request\AbstractRequest;
use Omnipay\WePay\Utilities\LazyLoadParametersTrait;

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
        $accepted = $this->getAcceptedParameters();
        $ret = [];
        foreach ($accepted as $param) {
            if ($param !== 'send_confirmation') {
                $ret[$param] = $this->getParameter($param);
            }
        }

        return $ret;
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
}
