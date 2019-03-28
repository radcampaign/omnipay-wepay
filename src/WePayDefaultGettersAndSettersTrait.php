<?php

namespace Omnipay\WePay;

trait WePayDefaultGettersAndSettersTrait
{
    /**
     * The WePay instance needs the clientId
     * @param string $value the client id
     */
    public function setClientId($value)
    {
        return $this->setParameter('client_id', $value);
    }

    /**
     * The wepay instance needs the client secret
     * @param string $value the client secret
     */
    public function setClientSecret($value)
    {
        return $this->setParameter('client_secret', $value);
    }

    /**
     * Retrieves from parameters the client id
     * @return string
     */
    public function getClientId()
    {
        return $this->getParameter('client_id');
    }

    /**
     * Retrieves the client secret
     * @return string
     */
    public function getClientSecret()
    {
        return $this->getParameter('client_secret');
    }

    /**
     * We need an accesstoken to for requests
     * @return string
     */
    public function getAccessToken()
    {
        return $this->getParameter('access_token');
    }

    /**
     * Sets the access token that we will generate requests for
     * @param string $value
     */
    public function setAccessToken($value)
    {
        return $this->setParameter('access_token', $value);
    }
}
