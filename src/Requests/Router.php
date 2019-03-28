<?php
/**
 * This is a helper class for resolving the endpoints
 * for requests based on whether or not the application is in test mode
 */
namespace Omnipay\WePay\Requests;

use Omnipay\WePay\Utilities\IsSingletonTrait;

class Router
{

    use IsSingletonTrait;

    /**
     * The live api url
     * @var string
     */
    const LIVE_API_URL = 'https://wepayapi.com/v2/';

    /**
     * The staging api url
     * @var string
     */
    const TEST_API_URL = 'https://stage.wepayapi.com/v2/';

    /**
     * Test mode - determines which url to use
     * @var boolean
     */
    protected static $testMode = false;

    /**
     * Sets the test mode
     * @param boolean $mode
     */
    public static function setTestMode($mode = false)
    {
        self::$testMode = $mode;
        return self::getInstance();
    }

    /**
     * Gets the test mode for the router
     * @return string
     */
    public static function getTestMode()
    {
        return self::$testMode;
    }

    /**
     * gets the api url based on whether the router is in test mode or not
     * @return string
     */
    public static function getApiUrl()
    {
        return self::getTestMode() ? self::TEST_API_URL : self::LIVE_API_URL;
    }

    /**
     * Gets the endpoint for the router and allows for the path
     * @param  string $path  a path to append to the url
     * @return string
     */
    public static function getEndpoint(string $path = '')
    {
        // remove webpoints that begin with
        if (substr($path, 0, 1) === '/') {
            $path = substr($path, 1);
        }
        return self::getApiUrl() . $path;
    }
}
