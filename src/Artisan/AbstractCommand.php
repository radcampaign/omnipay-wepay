<?php
/**
 * Abstract class for commands
 */
namespace Omnipay\WePay\Artisan;

abstract class AbstractCommand implements CommandInterface
{
    use ConsoleTrait;

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return $this->retProperty('name');
    }

    /**
     * {@inheritdoc}
     */
    public function getExample()
    {
        return $this->retProperty('example');
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription()
    {
        return $this->retProperty('description');
    }

    /**
     * {@inheritdoc}
     */
    public function getArguments()
    {
        return $this->retProperty('arguments');
    }

    /**
     * helper to retrieve class properties
     * @param  string $name the name of the property
     * @return mixed
     */
    protected function retProperty($name = '')
    {
        if (property_exists($this, $name)) {
            return $this->$name;
        }

        return null;
    }

    /**
     * Gets a command line option. options are passed as `--[name]=[value]`
     *
     * @param  string $name  option name
     * @return mixed
     */
    protected function getCLOption($name = '')
    {
        return Commander::getOption($name);
    }

    /**
     * Gets a command line argument - anything passed to our script beyond `php artisan`
     *
     * @param  int    $num
     * @return [type]      [description]
     */
    protected function getCLArgument(int $num)
    {
        return Commander::getArgument($num);
    }
}
