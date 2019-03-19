<?php

namespace Omnipay\WePay;

use Omnipay\Common\AbstractGateway;

class Gateway extends AbstractGateway
{
    use WePayGatewayTrait;

    public function getName()
    {
        return 'WePay';
    }
}
