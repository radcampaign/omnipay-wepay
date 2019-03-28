<?php

namespace Omnipay\WePay;

use Omnipay\Common\Helper as OmniHelper;

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

    /**
     * Strips null values from an array
     *
     * @param  array   $data
     * @param  boolean $reIndex   useful for non-associative array - resets the indexes using array_values
     * @return array
     */
    public static function arrayStripNulls(array $data = [], $reIndex = false)
    {
        $filtered = array_filter($data, function ($value) {
            return !is_null($value);
        });

        if ($reIndex) {
            $filtered = array_values($filtered);
        }

        return $filtered;
    }

    /**
     * Gets the name for a method that a parameter might use to retrieve
     * itself from a class
     *
     * @param  string $parameter
     * @return string
     */
    public static function getParameterSetter($parameter = '')
    {
        return 'set'.self::paramMethodized($parameter);
    }

    /**
     * Gets the name of a method that might be the setter for a specific parameter
     * on a class
     *
     * @param  string $parameter
     * @return string
     */
    public static function getParameterGetter($parameter = '')
    {
        return 'get'.self::paramMethodized($parameter);
    }

    /**
     * Turns the parameter into a string that setters and getters might use
     * as part of their method names
     *
     * @param  string $parameter
     * @return string
     */
    public static function paramMethodized($parameter = '')
    {
        return ucfirst(OmniHelper::camelCase($parameter));
    }

    /**
     * Helper to log output
     *
     * @param  mixed $args things that we want logged
     * @return void
     */
    public static function log(...$args)
    {
        if (!defined('OMNIPAY_WEPAY_DEBUG') || OMNIPAY_WEPAY_DEBUG === false) {
            return;
        }

        foreach ($args as $arg) {
            error_log(json_encode($arg, JSON_PRETTY_PRINT));
        }
    }
}
