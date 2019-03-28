<?php
/**
 * Interface for commands
 */
namespace Omnipay\WePay\Artisan;

interface CommandInterface
{
    /**
     * gets the name of the command
     * @return string
     */
    public function getName();

    /**
     * gets the example for the command
     * @return string
     */
    public function getExample();

    /**
     * gets the description for the command.
     * @return string
     */
    public function getDescription();

    /**
     * Gets the arguments for a command
     * @return string
     */
    public function getArguments();

    /**
     * Handles the command
     * @return void
     */
    public function handle();
}
