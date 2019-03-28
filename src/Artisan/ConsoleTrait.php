<?php
/**
 * Provides console functions like writeLine
 * and stuff
 */
namespace Omnipay\WePay\Artisan;

trait ConsoleTrait
{
    protected $console_colors = [
        'red' => 31,
        'yellow' => 33,
        'green' => 32,
        'white' => 37
    ];

    protected function writeLine($string = '', $indent = 0)
    {
        echo $string;
        $this->newLine();
    }

    protected function newLine()
    {
        echo "\n";
    }

    protected function whiteSpace($num = 0)
    {
        if ($num <= 0) {
            $num = 1;
        }

        echo str_repeat(' ', $num);
    }

    protected function warn($string, $indent = 0)
    {
        $this->writeLine($this->colorText($string, 'yellow'));
    }

    protected function log($string, $indent = 0)
    {
        $this->writeLine($this->colorText($string, 'green'));
    }

    protected function error($string, $indent = 0)
    {
        $this->writeLine($this->colorText($string, 'red'));
    }

    protected function colorText($string = '', $color = '')
    {
        $color = $this->getColor($color);
        if ($color !== false) {
            return sprintf("\033[%dm%s\033[0m", $color, $string);
        }

        return $string;
    }

    protected function getColor($color)
    {
        return $this->console_colors[$color] ?? false;
    }
}
