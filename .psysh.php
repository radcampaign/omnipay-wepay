<?php

// bootstrap our application
$autoload = getcwd() . '/vendor/autoload.php';
if (is_file($autoload)) {
    require_once $autoload;
}

// now lets load env and see if there is a .env-testing file
// with information that we can use to create a gateway
$testingEnv = getcwd() . '/.env-testing';
if (is_file($testingEnv)) {
    $dotenv = Dotenv\Dotenv::create(__DIR__, '.env-testing');
    $dotenv->load();
}

function testGateway() {
    $gateway = Omnipay\Omnipay::create('WePay');

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
