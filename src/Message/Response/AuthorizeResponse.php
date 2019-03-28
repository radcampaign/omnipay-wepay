<?php
/**
 * Request response
 */
namespace Omnipay\WePay\Message\Response;

use Omnipay\WePay\Message\Response\AbstractResponse;

class AuthorizeResponse extends AbstractResponse
{
    /**
     * Defines success for the request
     * @return {Boolean}
     */
    public function isSucessful()
    {
        // input your own success rules here
        return parent::isSuccessful() && !$this->dataIsEmpty();
    }
}
