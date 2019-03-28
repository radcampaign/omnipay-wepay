<?php
/**
 * @see  https://developer.wepay.com/api/api-calls/account#account
 */
namespace Omnipay\WePay\Account\Message\Request;

use Omnipay\WePay\Message\Request\AbstractRequest;
use Omnipay\WePay\Account\Message\Response\FindResponse;

class Find extends AbstractRequest
{
    /**
     * {@inheritdoc}
     */
    public function getData()
    {
        return [
            'account_id' => $this->getAccountId()
        ];
    }

    public function getEndpoint()
    {
        return 'account';
    }

    public function setAccountId($value)
    {
        return $this->setParameter('account_id', $value);
    }

    public function getAccountId()
    {
        return $this->getParameter('account_id');
    }

    protected function createResponse($data, $headers = [], $code, $status_reason = '')
    {
        return $this->response = new FindResponse($this, $data, $headers, $code, $status_reason);
    }
}
