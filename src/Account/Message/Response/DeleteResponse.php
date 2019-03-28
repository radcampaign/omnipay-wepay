<?php

namespace Omnipay\WePay\Account\Message\Response;

use Omnipay\WePay\Message\Response\AbstractResponse;

class DeleteResponse extends AbstractResponse
{
    public function isSucessful()
    {
        $reqNotEmpty = parent::isSuccessful();
        $stateIsDeleted = !empty($this->getData('state')) && $this->getData('state') === 'deleted';
        return  $reqNotEmpty && $stateIsDeleted;
    }
}
