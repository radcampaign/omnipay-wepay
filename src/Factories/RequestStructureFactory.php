<?php

namespace Omnipay\WePay\Factories;

use Omnipay\WePay\Utilities\IsSingletonTrait;
use InvalidArgumentException;
use Omnipay\WePay\Models\RequestStructures\RequestStructureInterface;
use Omnipay\WePay\Models\RequestStructures\RbitPropertiesInterface;
use Omnipay\Common\Helper;

class RequestStructureFactory
{
    use IsSingletonTrait;

    // Storage for all data structures
    public static $data_structures = [];

    /**
     * This is the namespace where
     * @var string
     */
    public static $namespace = '\\Omnipay\\WePay\\Models\\RequestStructures\\';

    /**
     * Cache for all of our discovered models
     *
     * @var array
     */
    protected static $registered_models = [];

    public static function rbitCreate($tag = '', array $data = [])
    {
        if (substr(strtolower($tag), 0, 4) !== 'rbit') {
            $tag = 'Rbit'.ucfirst(Helper::camelCase($tag));
        }
        return self::create($tag, $data);
    }

    /**
     * Creates an instance of a known data structure
     *
     * @param  string $tag                i.e Address - will resolve to Omnipay\WePay\Models\RequestStructures\Address
     * @param  array  $data               any data to load into our data structure
     * @return RequestStructureInterface
     * @throws InvalidArgumentException   if the the namespaced class does not exist
     */
    public static function create($tag = '', array $data = [], $creatingRbit = false)
    {
        $instance = self::getInstance();

        // make sure that the tag is in class format
        // this also means that we can add support for snake case
        // or lower cased name calls
        // so something like RequestStructureFactory::create::('hosted_factory')
        // should resolve to \Omnipay\WePay\Models\RequestStructures\HostedFactory
        $tag = ucfirst(Helper::camelCase($tag));

        return $instance->resolve($tag, $data, $creatingRbit);
    }

    public function resolve($tag = '', array $data = [], $creatingRbit = false)
    {
        $class = self::$namespace . $tag;
        if (self::isRegistered($class)) {
            return new $class($data);
        }

        if (class_exists($class)) {
            // throws an argument if the class does not have the right interface
            if (!self::classImplementsRequestStructureInterface($class)) {
                throw new InvalidArgumentException(
                    sprintf(
                        // phpcs:ignore
                        "Class %s found but it does not implement the %s interface.",
                        $class,
                        RequestStructureInterface::class
                    )
                );
            }

            if ($creatingRbit && !self::classIsRbitStructure($class)) {
                throw new InvalidArgumentException(
                    sprintf(
                        // phpcs:ignore
                        "Class %s found but either is not our base Rbit class or does not does not implement the %s interface.",
                        $class,
                        RbitPropertiesInterface::class
                    )
                );
            }

            self::registerModel($class);

            return new $class($data);
        }

        throw new InvalidArgumentException(
            sprintf(
                "Could not resolve %s. Class %s could not be found.",
                $tag,
                $class
            )
        );
    }

    /**
     * Registers a class as a known model
     *
     * @param  string $class
     * @return void
     */
    public static function registerModel($class = '')
    {
        if (!self::isRegistered($class)) {
            array_push(self::$registered_models, $class);
            sort(self::$registered_models);
        }
    }

    /**
     * Checks if a class has been registered as a known model
     *
     * @param  string  $class
     * @return boolean
     */
    public static function isRegistered($class = '')
    {
        return in_array($class, self::$registered_models);
    }

    public static function getRegisteredModels()
    {
        return self::$registered_models;
    }

    /**
     * Clears our cache
     * @return [type] [description]
     */
    public static function clearCache()
    {
        self::$registered_models = [];
    }

    /**
     * Ensures that a class implements the RequestStructureInterface
     *
     * @param  string $class
     * @return boolean
     */
    public static function classImplementsRequestStructureInterface($class = '')
    {
        return in_array(RequestStructureInterface::class, class_implements($class));
    }

    /**
     * Checks if a class is an Rbit structure
     *
     * @param  string $class
     * @return boolean
     */
    public static function classIsRbitStructure($class = '')
    {
        return $class == self::$namespace . 'Rbit' || in_array(
            RbitPropertiesInterface::class,
            class_implements($class)
        );
    }

    /**
     * Retrieves a lists all of our known models
     *
     * @return array
     */
    public static function listModels()
    {
        // scan our directory and register our models
        $files = scandir(join(DIRECTORY_SEPARATOR, [__DIR__, '..', 'Models','RequestStructures']));
        foreach ($files as $file) {
            $isPHPFile = strpos($file, '.php');
            $isNotInterface = strpos($file, 'Interface') === false;
            $isNotTrait = strpos($file, 'Trait') === false;
            $isNotAbstract = strpos($file, 'Abstract') === false;

            if ($isPHPFile && $isNotInterface && $isNotTrait && $isNotAbstract) {
                $class = self::$namespace . str_replace('.php', '', $file);
                if (class_exists($class) && self::classImplementsRequestStructureInterface($class)) {
                    self::registerModel($class);
                }
            }
        }

        return self::getRegisteredModels();
    }

    /**
     * Retrieves a list of all of our known rbit data models
     *
     * @return array
     */
    public static function listRbitModels()
    {
        $models = self::listModels();
        $ret = [];
        foreach ($models as $model) {
            if (self::classIsRbitStructure($model)) {
                array_push($ret, $model);
            }
        }
        return $ret;
    }
}
