<?php

namespace Omnipay\WePay\Factories;

use Omnipay\Common\Helper;
use Omnipay\WePay\Fakers\FakerInterface;

class FakerFactory
{
    protected static $namespace = '\\Omnipay\\WePay\\Fakers\\';

    public static function create($tag = '')
    {
        $tag = ucfirst(Helper::camelCase($tag));

        $class = self::$namespace . $tag;

        if (class_exists($class) && self::classImplementsInterface($class)) {
            return new $class;
        }
    }

    public static function classImplementsInterface($class = '')
    {
        return in_array(FakerInterface::class, class_implements($class));
    }
}
