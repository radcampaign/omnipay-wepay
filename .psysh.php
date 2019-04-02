<?php

/**
 * Set this to false if you want to do any testing
 */
define('OMNIPAY_WEPAY_DEBUG', TRUE);

// bootstrap our application
$autoload = getcwd() . '/vendor/autoload.php';
if (is_file($autoload)) {
    require_once $autoload;
}

use Omnipay\WePay\Factories\RequestStructureFactory;
use Omnipay\Common\CreditCard;
use Omnipay\WePay\Factories\FakerFactory;

// now lets load env and see if there is a .env-testing file
// with information that we can use to create a gateway
$testingEnv = getcwd() . '/.env-testing';
if (is_file($testingEnv)) {
    $dotenv = Dotenv\Dotenv::create(__DIR__, '.env-testing');
    $dotenv->load();
}

function getGateway($name = '') {
    if (empty($name)) {
        $name = 'create';
    }

    $gateway = Omnipay\Omnipay::$name('WePay');

    $access_token = getEnv('ACCESS_TOKEN');
    $client_id = getEnv('CLIENT_ID');
    $client_secret = getEnv('CLIENT_SECRET');

    $test_mode = getEnv('TEST_MODE');
    if (is_string($test_mode)) {
        $test_mode = strtolower($test_mode) === 'true';
    }

    $gateway->setAccessToken($access_token)
        ->setClientId($client_id)
        ->setClientSecret($client_secret)
        ->setTestMode($test_mode);

    return $gateway;
}

function testUserGateway() {
    return getGateway('user');
}

function testAccountGateway() {
    return getGateway('account');
}

function testPaymentGateway() {
    return getGateway('create');
}

$localFile = getcwd() . '/.psysh-local.php';
if (is_file($localFile)) {
    include_once $localFile;
}

function listDataStructures()
{
    return RequestStructureFactory::listModels();
}

function listRbitStructures()
{
    return RequestStructureFactory::listRbitModels();
}

function createRbit(array $data = [])
{
    return RequestStructureFactory::rbitCreate('', $data);
}

function getFakeCreditCardNumbers()
{
    $faker = FakerFactory::create('credit_card');
    $faker->setIncludeAddress(true);
    return $faker->fake();
}

function getFakeAddress()
{
    $faker = FakerFactory::create('address');
    return $faker->fake();
}

function testCreditCard()
{
    return new CreditCard(getFakeCreditCardNumbers());
}

function testAddress()
{
    return RequestStructureFactory::create('Address', getFakeAddress());
}

function testCreateCard()
{
    $gate = testPaymentGateway();
    $card = testCreditCard();
    return $gate->createCard()->setCard($card);
}

function testTransactionRbits()
{
    $rbit = RequestStructureFactory::create('Rbit');
    $rbit->type = "auto_billing";
    $rbit->receive_time = time();
    $rbit->source = "user";

    $auto_billing = RequestStructureFactory::create('RbitAutoBilling');
    $auto_billing->autobill_setup_time = $rbit->receive_time;
    $auto_billing->payment_number = 1;
    $auto_billing->payment_frequency = "monthly";
    $auto_billing->setup_by = "payer";

    $rbit->properties = $auto_billing;

    return $rbit;
}
