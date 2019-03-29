<?php
/**
 * A quick and dirty static accessor for our singleton ServicesRouter
 * class
 */
namespace Omnipay\WePay\Services;

class Services
{
    public static function __callStatic($method = '', $arguments = [])
    {
        $instance = ServicesRouter::getInstance();
        if (!method_exists($instance, $method)) {
            throw new \BadMethodCallException("$method does not exist");
        }
        return call_user_func_array([$instance, $method], $arguments);
    }
}
