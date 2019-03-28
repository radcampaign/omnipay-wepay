<?php
/**
 * Borrowed from laravel.
 *
 * @see https://laravel.com/api/5.0/Illuminate/Contracts/Support/Arrayable.html
 */
namespace Omnipay\WePay\Utilities;

interface ArrayableInterface
{
    /**
     * Returnes the instance as an array
     *
     * @return array
     */
    public function toArray();
}
