<?php
/**
 * Router for commands
 */
namespace Omnipay\WePay\Artisan;

use Omnipay\WePay\Utilities\IsSingletonTrait;

class Commander
{
    use IsSingletonTrait;

    /**
     * A place ot save all of the commands
     *
     * @var array
     */
    protected static $commands = [];

    /**
     * A place to save all of the console arguments
     * @var array
     */
    protected static $console_arguments = [];

    /**
     * A place to save all of the console options
     * @var array
     */
    protected static $console_options = [];

    /**
     * Constructs our Commander program
     */
    public function __construct()
    {

        $dir = __DIR__ . '/Commands';

        if (is_dir($dir)) {
            $files = scandir($dir);
            foreach ($files as $file) {
                if (strpos($file, '.php') > 0) {
                    $this->registerCommand(rtrim($file, '.php'));
                }
            }
        }

        ksort(self::$commands); // sort commands by key
    }

    protected function registerCommand($name = '')
    {
        $namespace = 'Omnipay\\WePay\\Artisan\\Commands\\';
        $class_name = $namespace . $name;
        if (class_exists($class_name) &&
            in_array(CommandInterface::Class, class_implements($class_name)) &&
            !in_array($class_name, self::$commands)
        ) {
            $class = new $class_name;
            self::$commands[$class->getName()] = $class;
        }
    }

    /**
     * Checks if a particular command has been registered
     *
     * @param  string  $name
     * @return boolean
     */
    public function isRegistered($name = '')
    {
        return isset(self::$commands[$name]);
    }

    /**
     * Get's the command object
     *
     * @param  string $name the name of the command
     * @return CommandInterface
     */
    public function getCommand($name = '')
    {
        return self::$commands[$name];
    }

    /**
     * Handles the running of a command a command
     *
     * @param  string $arguments  all of the arguments passed to our artisan script
     * @return void
     */
    public static function initialize($arguments = [])
    {
        $command = array_shift($arguments); // retrieves our command

        // filter out our options and save them
        $options = [];
        foreach ($arguments as $index => $argument) {
            if (strpos($argument, '-') === 0) {
                $options[] = $argument;
            }
        }
        self::setOptions($options);

        $diff = array_diff($arguments, $options);

        // now save what's rest of the arguments
        self::setArguments(array_values($diff)); // set the arguments

        if (is_null($command)) {
            echo "Please tell us what to do. Use `php artisan list` to see the available commands";
            return;
        }

        $instance = self::getInstance();
        if (!$instance->isRegistered($command)) {
            echo sprintf('The command %s is not registered', $command);
            return;
        }

        $instance->getCommand($command)->handle();
    }

    /**
     * Gets all of the available commands keys by command name and valued by the command object
     *
     * @return array
     */
    public static function getCommands()
    {
        return self::$commands;
    }

    /**
     * A way for our command line script to set the passed arguments
     *
     * @param array $arguments
     */
    public static function setArguments($arguments = [])
    {
        self::$console_arguments = $arguments;
    }

    /**
     * retrieves the command line arguments
     *
     * @return array
     */
    public static function getArguments()
    {
        return self::$console_arguments;
    }

    /**
     * Retreives an argument from command line
     *
     * @param  integer $num [description]
     * @return string
     */
    public static function getArgument(int $num)
    {
        return self::$console_arguments[$num] ?? null;
    }

    /**
     * saves our array of options
     *
     * @param array $options
     */
    public static function setOptions($options = [])
    {
        self::$console_options = $options;
    }

    /**
     * Gets options
     *
     * @return array
     */
    public static function getOptions()
    {
        return self::$console_options;
    }

    /**
     * Retrieves an option that was passed to the command line
     *
     * @param  string $name
     * @return mixed
     */
    public static function getOption($name = '')
    {
        if (empty($name)) {
            return null;
        }

        $args = self::getOptions();
        if (empty($args)) {
            return null;
        }

        $test = '--' . $name;

        foreach ($args as $arg) {
            $bits = explode('=', $arg);
            if ($bits[0] === $test) {
                $values = str_getcsv($bits[1] ?? null);
                return count($values) === 1 ? $values[0] : $values;
            }
        }

        return null;
    }
}
