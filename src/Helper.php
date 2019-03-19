<?php

namespace Omnipay\WePay;

class Helper
{
    /**
     * Converts a string that is presumed to be in camel case to
     * snake case
     * @param  string $string
     * @return string
     */
    public static function snakeCase($string = '')
    {
        // see https://stackoverflow.com/a/19533226
        return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $string));
    }
}
