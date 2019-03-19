<?php

namespace Omnipay\WePay\User;

use Omnipay\Common\AbstractGateway;
use WePay;
use WePayException;
use WePayRequestException;
use RuntimeException;
## get our requests
use Omnipay\WePay\User\Message\Request\Find;
use Omnipay\WePay\User\Message\Request\Modify;
use Omnipay\WePay\User\Message\Request\Register;
use Omnipay\WePay\User\Message\Request\SendConfirmation;
use Omnipay\WePay\WePayGatewayTrait;

/**
 * Defines our Gateway class.
 * Our gateway class will initialize. To do this,
 * you must pass clientId and clientSecret into the gateway
 */
class Gateway extends AbstractGateway
{
    use WePayGatewayTrait;

    /**
     * Find the user
     * @return RequestInterface
     */
    public function find(array $parameters = [])
    {
        return $this->createRequest(Find::class, $parameters);
    }

    /**
     * Request to modify user
     * @param  array  $parameters [description]
     * @return RequestInterface
     */
    public function modify(array $parameters = [])
    {
        return $this->createRequest(Modify::class, $parameters);
    }

    /**
     * Request to register a user
     * @param  array  $parameters
     * @return RequestInterface
     */
    public function register(array $parameters = [])
    {
        return $this->createRequest(Register::class, $parameters);
    }

    /**
     * Not required by gateway but available in the WePay Api
     * @param  array  $parameters
     * @return RequestInterface
     */
    public function sendConfirmation(array $parameters = [])
    {
        return $this->createRequest(SendConfirmation::class, $parameters);
    }
}
