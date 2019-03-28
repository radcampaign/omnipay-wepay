<?php

namespace Omnipay\WePay\Artisan\Commands;

use Omnipay\WePay\Artisan\AbstractCommand;
use Omnipay\WePay\Artisan\Commander;

class ListCommand extends AbstractCommand
{
    protected $name = 'list';

    protected $example = 'php artisan list';

    protected $description = 'Displays a list all available commands';

    public function handle()
    {
        $registered_commands = Commander::getCommands();

        $len = count($registered_commands);
        $counter = 0;
        $default_indent = 25;
        foreach ($registered_commands as $name => $tmp) {
            echo $name;
            echo $this->WhiteSpace($default_indent - strlen($name)) . $tmp->getDescription();

            $example = $tmp->getExample();
            if (!empty($example)) {
                $this->newLine();
                echo $this->whiteSpace($default_indent) . 'example: `' . $example . '`';
            }

            $arguments = $tmp->getArguments();
            if (!empty($arguments) && is_array($arguments)) {
                $this->newLine();
                echo $this->whiteSpace($default_indent) . 'arguments:';

                foreach ($arguments as $argument => $data) {
                    $this->newLine();
                    $show = $this->whiteSpace($default_indent + 1) . '- ' . $argument;
                    if (isset($data['description'])) {
                        $show .= ' - ' . $data['description'];
                    }
                    echo $show;
                }
            }

            if ($counter !== ($len - 1)) {
                $this->newLine();
                $this->newLine();
            }

            $counter++;
        }

         $this->newLine();
    }
}
