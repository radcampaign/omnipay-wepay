<?php
/**
 * Creates fake data that can be used to test
 * parts of our application.
 *
 * @see https://github.com/fzaninotto/Faker
 */
namespace Omnipay\WePay\Fakers;

/**
 * Our Address class.
 *
 * Example:
 *
 * <code>
 *     $faker = Omnipay\WePay\Factories\FakerFactory::create('Address');
 *     $data = $faker->fake(); // returns fake data
 * </code>
 */
class Address extends AbstractFaker
{
    /**
     * {@inheritdoc}
     */
    public function fake()
    {
        // retrieves our Faker\Generator
        $faker = $this->generator();

        $address = [
            'address1' => join(' ', [$faker->buildingNumber(), $faker->streetName()]),
            'address2' => $faker->secondaryAddress(),
            'city'     => $faker->city(),
            'region'   => $faker->stateAbbr(),
            'country'  => 'US',
            'postal_code' => $faker->postcode(),
        ];

        return $address;
    }
}
