<?php

namespace Omnipay\WePay;

use Omnipay\WePay\Requests\Router;

trait RouterHooksTestModeTrait
{
    /**
     * {@inheritdoc}
     *
     * hooking into our setTestMode so that the router updates
     * whenever we change the test mode of the gateway
     * @param boolean
     */
    public function setTestMode($value)
    {
        Router::setTestMode($value);

        return parent::setTestMode($value);
    }
}
