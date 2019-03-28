<?php

namespace Omnipay\WePay\Account;

use Omnipay\Common\AbstractAccountGateway;
use WePay;
use WePayException;
use WePayRequestException;
use RuntimeException;
use Omnipay\WePay\WePayGatewayTrait;
## get our requests
use Omnipay\WePay\Account\Message\Request\Find;
use Omnipay\WePay\Account\Message\Request\Modify;
use Omnipay\WePay\Account\Message\Request\Create;
use Omnipay\WePay\Account\Message\Request\Delete;
use Omnipay\WePay\Account\Message\Request\GetUpdateUri;

/**
 * Defines our Gateway class.
 * Our gateway class will initialize. To do this,
 * you must pass clientId and clientSecret into the gateway
 */
class Gateway extends AbstractAccountGateway
{
    use WePayGatewayTrait;

    protected $added_parameters = [
        'account_id' => 0
    ];

    /**
     * Use this call to lookup the details of a payment account on WePay.
     * The payment account must belong to the user associated with the
     * access token used to make the call.
     *
     * @see  https://developer.wepay.com/api/api-calls/account#account
     * @param  array  $paramters
     * @return RequestInterface
     */
    public function find(array $parameters = [])
    {
        return $this->createRequest(Find::class, $parameters);
    }

    /**
     * User this call to modify the details of an account
     *
     * @see  https://developer.wepay.com/api/api-calls/account#modify
     * @param  array  $parameters
     * @return RequestInterface
     */
    public function modify(array $parameters = [])
    {
        return $this->createRequest(Modify::class, $parameters);
    }

    /**
     * Use this call to create a new merchant account for the user
     *
     * @see  https://developer.wepay.com/api/api-calls/account#create
     * @param  array  $parameters
     * @return RequestInterface
     */
    public function create(array $parameters = [])
    {
        return $this->createRequest(Create::class, $parameters);
    }

    public function getUpdateUri(array $parameters = [])
    {
        return $this->createRequest(GetUpdateUri::class, $parameters);
    }

    /**
     * Use this call to delete a user's merchant account
     *
     * @see  https://developer.wepay.com/api/api-calls/account#delete
     * @param  array  $parameters
     * @return RequestInterface
     */
    public function delete(array $parameters = [])
    {
        return $this->createRequest(Delete::class, $parameters);
    }

    public function setAccountId($value)
    {
        return $this->setParameter('account_id', $value);
    }

    public function getAccountId()
    {
        return $this->getParameter('account_id');
    }
}
