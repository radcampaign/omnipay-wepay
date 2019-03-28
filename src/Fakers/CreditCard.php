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
    /**
     * {@inheritdoc}
     */
    public function fake()
    {
        // retrieves our Faker\Generator
        $faker = $this->generator();

        $card = [
            'number'    => $faker->creditCardNumber(),
            'firstName' => $faker->firstName(),
            'lastName'  => $faker->lastName(),
            'email'     => $faker->email(),
        ];

        // get a random card and add some fake expiry month and year info
        $card['expiryMonth'] = str_pad((string) rand(1, 12), 2, "0", STR_PAD_LEFT);
        $start_year = (int) date('Y');
        $card['expiryYear'] = (string) rand($start_year + 1, $start_year + 10);
        $card['cvv'] = (string) rand(100, 999);

        return $card;
    }
}
