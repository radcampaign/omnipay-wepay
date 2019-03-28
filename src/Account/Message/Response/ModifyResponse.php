<?php

namespace Omnipay\WePay\Account\Message\Response;

use Omnipay\WePay\Message\Response\AbstractResponse;

class ModifyResponse extends AbstractResponse
{
    public function isSucessful()
    {
        return parent::isSuccessful() && !empty($this->getData());
    }
}
