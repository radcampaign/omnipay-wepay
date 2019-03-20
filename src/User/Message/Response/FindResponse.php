<?php

namespace Omnipay\WePay\User\Message\Response;

use Omnipay\WePay\Message\Response\AbstractResponse;

class FindResponse extends AbstractResponse
{
    /**
     * The response is a success only when the data is not empty and when the
     * response does not contain and error
     * @return boolean
     */
    public function isSuccessful()
    {
        return parent::isSuccessful() && !empty($this->getData());
    }
}
