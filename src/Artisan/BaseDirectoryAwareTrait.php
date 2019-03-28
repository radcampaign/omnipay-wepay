<?php

namespace Omnipay\WePay\Artisan;

trait BaseDirectoryAwareTrait
{
    /**
     * Storage for our base directory path
     * @var string
     */
    protected $baseDir = '';

    /**
     * Retrieves the base directory path
     * @return string
     */
    protected function getBaseDirectory()
    {
        if (empty($this->baseDir)) {
            $this->baseDir = defined('ARSTISAN_BASE_DIR') ? ARTISAN_BASE_DIR : getcwd();
        }

        return $this->baseDir;
    }
}
