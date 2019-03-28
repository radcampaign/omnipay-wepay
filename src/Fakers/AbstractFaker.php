<?php

namespace Omnipay\WePay\Fakers;

use Faker\Factory;

abstract class AbstractFaker implements FakerInterface
{
    /**
     * {@inherit}
     */
    abstract public function fake();

    /**
     * Gets the gaker generator
     *
     * @return Faker\Generator
     */
    protected function generator()
    {
        return Factory::create();
    }
}
