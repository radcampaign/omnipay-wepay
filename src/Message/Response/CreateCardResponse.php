<?php
/**
 * Request response
 */
namespace Omnipay\WePay\Message\Response;

use Omnipay\WePay\Message\Response\AbstractResponse;

class CreateCardResponse extends AbstractResponse
{
    /**
     * Defines success for the request
     * @return boolean
     */
    public function isSuccessful()
    {
        return parent::isSuccessful() && !is_null($this->getToken());
    }

    /**
     * Gets the credit card id
     * @return void
     */
    public function getToken()
    {
        return $this->getData('credit_card_id');
    }
}
