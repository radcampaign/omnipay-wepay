<?php

namespace Omnipay\WePay\User\Message\Request;

use Omnipay\WePay\Message\Request\AbstractRequest;

class Find extends AbstractRequest
{
    /**
     * {@inheritdoc}
     * @return array
     */
    public function getData()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function getEndpoint()
    {
        return 'user';
    }
}
