<?php

namespace Omnipay\WePay\User\Message\Response;

use Omnipay\WePay\Message\Response\AbstractResponse;

class ModifyResponse extends AbstractResponse
{
    /**
     * The response is a success only when the data is not empty and when the
     * response does not contain and error
     * @return boolean
     */
    public function isSuccessful()
    {
        $data = $this->getData();
        $dataIsNotEmpty = !empty($data);
        $responseDoesNotHaveError = parent::isSuccessful();
        $responseCBUriEqualsRequestCBUri = $this->getRequest()->getCallbackUri() == ($data['callback_uri'] ?? false);
        return $dataIsNotEmpty && $responseDoesNotHaveError && $responseCBUriEqualsRequestCBUri;
    }
}
