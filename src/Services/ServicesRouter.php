<?php
/**
 * This is a router for services
 */
namespace Omnipay\WePay\Services;

use Omnipay\WePay\Utilities\IsSingletonTrait;

class ServicesRouter
{
    use IsSingletonTrait;

    protected $registered = [
        'rs_cc' => RequestStructureCreditCardConform::Class
    ];

    public function get($service = '')
    {
        if (array_key_exists($service, $this->registered)) {
            return new $this->registered[$service];
        }

        throw new \Exception("Could not find a registered service for $service");
    }
}
