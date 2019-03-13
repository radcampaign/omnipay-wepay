<?php

namespace Omnipay\WePay;

use Omnipay\Common\AbstractGateway;
use WePay;
use WePayException;
use WePayRequestException;
use RuntimeException;

## get our requests
use Omnipay\WePay\Message\Request\UserRequest;

/**
 * Defines our Gateway class.
 * Our gateway class will initialize. To do this,
 * you must pass clientId and clientSecret into the gateway
 */
class Gateway extends AbstractGateway
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'wepay';
    }

    /**
     * The WePay instance needs the clientId
     * @param string $value the client id
     */
    public function setClientId($value)
    {
        return $this->setParameter('clientId', $value);
    }

    /**
     * The wepay instance needs the client secret
     * @param string $value the client secret
     */
    public function setClientSecret($value)
    {
        return $this->setParameter('clientSecret', $value);
    }

    /**
     * Retrieves from parameters the client id
     * @return string
     */
    public function getClientId()
    {
        return $this->getParameter('clientId');
    }

    /**
     * Retrieves the client secret
     * @return string
     */
    public function getClientSecret()
    {
        return $this->getParameter('clientSecret');
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultParameters()
    {
        return [
            'accessToken' => '',
            'clientId' => '',
            'clientSecret' => '',
            'testMode' => false
        ];
    }

    /**
     * We need an accesstoken to for requests
     * @return string
     */
    public function getAccessToken()
    {
        return $this->getParameter('accessToken');
    }

    /**
     * Sets the access token that we will generate requests for
     * @param string $value
     */
    public function setAccessToken($value)
    {
        return $this->setParameter('accessToken', $value);
    }

    /**
     * Gets the user's data for the access token
     * @param  array  $parameters Can pass another access token
     * @return Omnipay\WePay\Message\Request\UserRequest
     */
    public function user(array $parameters = [])
    {
        return $this->createRequest(UserRequest::class, $parameters);
    }
}
