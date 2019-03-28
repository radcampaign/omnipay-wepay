<?php

namespace Omnipay\WePay;

use Omnipay\Common\AbstractGateway;
// our requests
use Omnipay\WePay\Message\Request\Authorize;
use Omnipay\WePay\Message\Request\Purchase;
use Omnipay\WePay\Message\Request\CreateCard;

class Gateway extends AbstractGateway
{
    use WePayGatewayTrait;

    public function getName()
    {
        return 'WePay';
    }

    /**
     * Authorize a credit card
     *
     * @param  array  $parameters the parameters to pass to the request
     * @return \Omnipay\WePay\Message\Request\Authorize
     */
    public function authorize(array $parameters = [])
    {
        return $this->createRequest(Authorize::class, $parameters);
    }

    // public function completesAuthorize(array $parameters = [])
    // {

    // }

    // public function capture(array $parameters = [])
    // {

    // }

    public function purchase(array $parameters = [])
    {
        return $this->createRequest(Purchase::class, $parameters);
    }

    // public function completePurchase(array $parameters = [])
    // {

    // }

    // public function fetchTransaction(array $parameters = [])
    // {

    // }

    // public function refund(array $parameters = [])
    // {

    // }

    // public function void(array $parameters = [])
    // {

    // }

    public function createCard(array $parameters = [])
    {
        return $this->createRequest(CreateCard::class, $parameters);
    }

    // public function createCard(array $parameters = [])
    // {

    // }

    // public function updateCade(array $parameters = [])
    // {

    // }
}
