<?php

namespace Omnipay\WePay\User\Message\Request;

use Omnipay\WePay\Message\Request\AbstractRequest;
use Omnipay\WePay\User\Message\Response\FindResponse;

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

    protected function createResponse($data, $headers = [], $code, $status_reason = '')
    {
        return $this->response = new FindResponse($this, $data, $headers, $code, $status_reason);
    }
}
