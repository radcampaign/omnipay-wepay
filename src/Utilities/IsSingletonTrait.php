<?php
/**
 * A quick n dirty singleton trait
 */
namespace Omnipay\WePay\Utilities;

/**
 * A Singleton Trait
 *
 * scaffolds your class to be a singleton
 *
 * If you include in your class a static method named "createInstance",
 * then getInstance will use that instead. Otherwise, the default it to create the
 * class using `new static()`.
 */
trait IsSingletonTrait
{
    protected static $instance = null;

    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            if (method_exists(__CLASS__, 'createInstance')) {
                self::$instance = self::createInstance();
            } else {
                self::$instance = new static();
            }
        }

        return self::$instance;
    }
}
