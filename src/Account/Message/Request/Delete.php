<?php
/**
 * @see  https://developer.wepay.com/api/api-calls/account#create
 */
namespace Omnipay\WePay\Account\Message\Request;

use Omnipay\WePay\Message\Request\AbstractRequest;
use Omnipay\WePay\Account\Message\Response\DeleteResponse;
use Omnipay\WePay\Utilities\LazyLoadParametersTrait;

class Delete extends AbstractRequest
{
    /**
     * {@inheritdoc}
     */
    public function getData()
    {
        $data = [
            'account_id' => $this->getAccountId()
        ];

        $reason = $this->getReason();
        if (!empty($reason)) {
            $data['reason'] = $reason;
        }

        return $data;
    }

    public function getEndpoint()
    {
        return 'account/delete';
    }

    protected function createResponse($data, $headers = [], $code = null, $status_reason = '')
    {
        return $this->response = new DeleteResponse($this, $data, $headers, $code, $status_reason);
    }

    public function setAccountId($value)
    {
        return $this->setParameter('account_id', $value);
    }

    public function getAccountId()
    {
        return $this->getParameter('account_id');
    }

    public function setReason($value)
    {
        return $this->setParameter('reason', $value);
    }

    public function getReason()
    {
        return $this->getParameter('reason');
    }
}
