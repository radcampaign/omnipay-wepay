<?php
/**
 * Address Structure
 */
namespace Omnipay\WePay\Models\RequestStructures;

class Address extends AbstractRequestStructure
{
    protected $required_parameters = [
        'postal_code',
        'country'
    ];

    protected $optional_parameters = [
        'address1',
        'address2',
        'city',
        'region'
    ];
}
