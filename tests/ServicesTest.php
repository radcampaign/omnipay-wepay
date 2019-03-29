<?php

namespace Omnipay\WePay;

use PHPUnit\Framework\TestCase;
use Omnipay\WePay\Services\Services;
use Omnipay\WePay\Factories\FakerFactory;
use Omnipay\Common\CreditCard;
use Omnipay\WePay\Models\RequestStructures\Address;

class ServicesTest extends TestCase
{
    public function testAddressRequestStructureConformer()
    {
        // get a faker
        $faker = FakerFactory::create('credit_card');
        $faker->setIncludeAddress(true); // include an address

        // create the credit card
        $card = new CreditCard($faker->fake());

        // get our service
        $service = Services::get('rs_cc')
                    ->setCreditCard($card)
                    ->setRSTAg('address');

        // retrieve our new RS address
        $address = $service->invoke();

        // now lets test some stuff
        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame($address->getPostalCode(), $card->getBillingPostcode());
        $this->assertSame($address->getAddress1(), $card->getBillingAddress1());
        $this->assertSame($address->getAddress2(), $card->getBillingAddress2());
        $this->assertSame($address->getCity(), $card->getBillingCity());
    }
}
