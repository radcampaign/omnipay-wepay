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
trait isSingletonTrait
{
    protected static $_instance = null;

    public static function getInstance()
    {
        if (is_null(self::$_instance)) {
            if (method_exists(__CLASS__, 'createInstance')) {
                self::$_instance = self::createInstance();
            }
            else {
                self::$_instance = new static();
            }
        }

        return self::$_instance;
    }
}
