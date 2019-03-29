<?php
/**
 * Creates fake data that can be used to test
 * parts of our application.
 *
 * @see https://github.com/fzaninotto/Faker
 */
namespace Omnipay\WePay\Fakers;

/**
 * Our CreditCard class.
 *
 * Example:
 *
 * <code>
 *     $faker = Omnipay\WePay\Factories\FakerFactory::create('CreditCard');
 *     $data = $faker->fake(); // returns fake data
 * </code>
 */
class CreditCard extends AbstractFaker
{
    protected $includeAddress = false;

    /**
     * {@inheritdoc}
     */
    public function fake()
    {
        // retrieves our Faker\Generator
        $faker = $this->generator();

        $first_name = $faker->firstName();
        $last_name = $faker->lastName();
        $card = [
            'number'    => $faker->creditCardNumber(),
            'firstName' => $first_name,
            'lastName'  => $last_name,
            'email'     => $first_name . '.' . $last_name . '@example.com',
        ];

        if ($this->getIncludeAddress()) {
            $address = (new Address())->fake();
            $address['postcode'] = $address['postal_code'];
            $card = array_merge($card, $address);
        }

        // get a random card and add some fake expiry month and year info
        $card['expiryMonth'] = str_pad((string) rand(1, 12), 2, "0", STR_PAD_LEFT);
        $start_year = (int) date('Y');
        $card['expiryYear'] = (string) rand($start_year + 1, $start_year + 10);
        $card['cvv'] = (string) rand(100, 999);

        return $card;
    }

    public function setIncludeAddress(bool $include = false)
    {
        $this->includeAddress = $include;
        return $this;
    }

    public function getIncludeAddress()
    {
        return $this->includeAddress;
    }
}
