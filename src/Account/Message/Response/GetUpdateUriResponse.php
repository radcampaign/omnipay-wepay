<?php

namespace Omnipay\WePay\Account\Message\Response;

use Omnipay\WePay\Message\Response\AbstractResponse;

class GetUpdateUriResponse extends AbstractResponse
{
    public function isSuccessful()
    {
        $reqNotEmpty = parent::isSuccessful();
        $uriPresent = !empty($this->getData('uri'));
        return  $reqNotEmpty && $uriPresent;
    }
}
