<?php

namespace Omnipay\WePay\User\Message\Request;

use Omnipay\WePay\Message\Request\AbstractRequest;
use Omnipay\WePay\User\Message\Response\ModifyResponse;

class Modify extends AbstractRequest
{
    /**
     * {@inheritdoc}
     * @return array
     */
    public function getData()
    {
        return [
            'callback_uri' => $this->getCallbackUri()
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getEndpoint()
    {
        return 'user/modify';
    }

    public function getCallbackUri()
    {
        return $this->getParameter('callback_uri');
    }

    public function setCallbackUri($value)
    {
        return $this->setParameter('callback_uri', $value);
    }

    protected function createResponse($data, $headers = [], $code = null, $status_reason = '')
    {
        return $this->response = new ModifyResponse($this, $data, $headers, $code, $status_reason);
    }
}
