# OmniPay WePay Driver

This library is a based on the [collizo4sky/omnipay-wepay](https://github.com/collizo4sky/omnipay-wepay) project. The [collizo4sky/omnipay-wepay](https://github.com/collizo4sky/omnipay-wepay) project is the Omnipay v2 driver for [WePay](https://go.wepay.com/). This is an attempt to update that project to Omnipay v3. For Omnipay v2 see [collizo4sky/omnipay-wepay](https://github.com/collizo4sky/omnipay-wepay).

Secondly, this project was built for compatibility with the [radcampaign/omnipay-common](https://github.com/radcampaign/omnipay-common/tree/uasupport) fork of the omnipay/common package. This branch is being worked on to support more than just a payment gateway. It includes a User gateway and an Account gateway for creating, modifying, and finding users and accounts. However, it should still be compatible with omnipay/common but I'm not sure if it will pass the tests.

## How to Use

This project was built with the [radcampaign/omnipay-common](https://github.com/radcampaign/omnipay-common/tree/uasupport) fork in mind.

To retrieve the payment gateway, run:
```
$gateway = Omnipay\Omnipay::create('WePay');
// you can also run
$gateway = Omnipay\Omnipay::payment('WePay');
```

To retrieve the account gateway, run:
```
$gateway = Omnipay\Omnipay::account('WePay');
```

To retrieve the user gateway, run:
```
$gateway = Omnipay\Omnipay::user('WePay');
```

## Testing

After install the package, simply run `composer run-tests` or call `./vendor/bin/phpunit` from the project directory. This project requires the radcampaign/omnipay-tests fork of omnipay/omnipay-tests.

## Developing

Have ideas? Please fork and submit a pull request. Or email us at info@radcampaign.com. Just like they say over at the League of Extraordinary Packages, no idea is too big or too small.

For testing, We included the [psysh](https://psysh.org/) package. To use the interactive shell, simply run `./cli` from the command line or run `./vendor/bin/pysh`. This project includes a `.psysh.php` configuration to bootstrap the environment and define some helpful functions for the cli environment. It also has support for a `.psysh-local.php` that is git ignored for any custom functions you may want to include.

### Artisan

A command line tool for stubbing your project. Yeah, so what? I stole the name from Laravel. I wasn't feeling particularly creative when I wrote artisan. Nonetheless, to see what commands are available, simply run `php artisan list`.

