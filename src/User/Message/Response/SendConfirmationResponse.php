<?php

namespace Omnipay\WePay\User\Message\Response;

use Omnipay\WePay\Message\Response\AbstractResponse;

class SendConfirmationResponse extends AbstractResponse
{
    /**
     * The response is a success only when the data is not empty and when the
     * response does not contain and error
     * @return boolean
     */
    public function isSuccessful()
    {
        $responseDoesNotHaveError = parent::isSuccessful();
        $responseHasUserid = !empty($this->getData('user_id'));
        return $responseDoesNotHaveError && $responseHasUserid;
    }
}
