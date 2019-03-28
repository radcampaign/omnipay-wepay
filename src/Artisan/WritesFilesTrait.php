<?php

namespace Omnipay\WePay\Artisan;

trait WritesFilesTrait
{
    protected function writeFile($location, $contents)
    {
        $file = fopen($location, "w");
        fwrite($file, $contents);
        fclose($file);
    }
}
