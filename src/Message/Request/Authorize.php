<?php
/**
 * Makes Requests
 */
namespace Omnipay\WePay\Message\Request;

use Omnipay\WePay\Message\Request\AbstractRequest;
use Omnipay\WePay\Message\Response\AuthorizeResponse;
use Omnipay\WePay\Utilities\LazyLoadParametersTrait;

class Authorize extends AbstractRequest
{
    /**
     * Uses overloading for lazy loading parameters so that
     * we don't have to write setters and getters for each one
     * - must set the class property `$accepted_parameters`
     * DELETE THIS IF YOU DON'T WANT TO USE IT
     */
    // use LazyLoadParametersTrait;

    /**
     * {@inheritdoc}
     */
    public function getData()
    {
        // use this to define the data
        return [
            'client_id' => $this->getClientId(),
            'client_secret' => $this->getClientSecret(),
            'credit_card_id' => $this->getCreditCardId(),
            'account_id' => $this->getAccountId()
        ];
    }

    public function getEndpoint()
    {
        // set the endpoint
        return 'credit_card/authorize';
    }

    protected function createResponse($data, $headers = [], $code, $status_reason = '')
    {
        return $this->response = new AuthorizeResponse($this, $data, $headers, $code, $status_reason);
    }

    /*
     Our getters and setters
     */

    public function setCreditCardId($value)
    {
        return $this->setParameter('credit_card_id', $value);
    }

    public function setCrediCardSecret($value)
    {
        return $this->setParameter('credit_card_secret', $value);
    }

    public function setAccountId($value)
    {
        return $this->setParameter('account_id', $value);
    }

    public function getCreditCardId()
    {
        return $this->getParameter('credit_card_id');
    }

    public function getCrediCardSecret()
    {
        return $this->getParameter('credit_card_secret');
    }

    public function getAccountId()
    {
        return $this->getParameter('account_id');
    }
}
