<?php

namespace Omnipay\WePay\Message\Request;

class UserRequest extends AbstractRequest
{
    /**
     * @see  getEndpoint
     * @var string
     */
    protected $endpoint = 'user';

    /**
     * @return string  the endpoint that the request will ping
     */
    public function getEndpoint()
    {
        return $this->endpoint;
    }

    /**
     * {@inheritdoc}
     */
    public function getData()
    {
        return  [];
    }
}
