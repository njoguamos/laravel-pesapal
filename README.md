> **warning** This package is still under development and is not ready for use in production. Please do not use it in production until this warning is removed.

![](https://banners.beyondco.de/Laravel%20Pesapal.png?theme=light&packageManager=composer+require&packageName=artisanelevated%2Flaravel-pesapal&pattern=rain&style=style_2&description=A+Laravel+package+for+interacting+with+https%3A%2F%2Fwww.pesapal.com+api&md=1&showWatermark=0&fontSize=100px&images=https%3A%2F%2Flaravel.com%2Fimg%2Flogomark.min.svg)

# A Laravel package for interacting with Pesapal API

[![Latest Version on Packagist](https://img.shields.io/packagist/v/artisanelevated/laravel-pesapal.svg?style=flat-square)](https://packagist.org/packages/artisanelevated/laravel-pesapal)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/artisanelevated/laravel-pesapal/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/artisanelevated/laravel-pesapal/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/artisanelevated/laravel-pesapal/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/artisanelevated/laravel-pesapal/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/artisanelevated/laravel-pesapal.svg?style=flat-square)](https://packagist.org/packages/artisanelevated/laravel-pesapal)

- [] TODO: Add a description of the package

## Support us

- [] TODO: Add a link to the support page

## Why use this package
- To provide a way of generating Pesapal api `access_token` which normally expires after 5 minutes
- Offer a gateway to interacting with Pesapal v3 API

## Installation

You can install the package via composer:

```bash
composer require artisanelevated/laravel-pesapal
```

Publish and run the migrations with:

```bash
php artisan vendor:publish --tag="pesapal-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="pesapal-config"
```

Update your environment variables in your application.

```dotenv
PESAPAL_LIVE=
PESAPAL_CONSUMER_KEY=
PESAPAL_CONSUMER_SECRET=
```

## Usage

### Generate `access_token`

To generate an `access_token` you can run the following command:

```bash
php artisan pesapal:auth
```

The command will get a fresh `access_token` from Pesapal API using the `CONSUMER_KEY` and `CONSUMER_SECRET` and save it in the database. The `access_token` is valid for 5 minutes therefore is wise to schedule the command to run every 4 minutes. In addition, when you have set `model:prune` command, all expired `access_token` will be deleted from the database since they are no longer useful.

```php
 # Laravel 10 -> app/Console/Kernel.php
 
class Kernel extends ConsoleKernel
{
 
    protected function schedule(Schedule $schedule): void
    {
        # Other scheduled commands
        $schedule->command('pesapal:auth')->everyFourMinutes();
        $schedule->command('model:prune')->daily();
    }
}
```

```php
 # Laravel 11 -> routes/console.php
Schedule::call('pesapal:auth')->everyFourMinutes();
Schedule::call('model:prune')->everyFourMinutes();
```

## Testing

> **Info** Where possible, the tests uses real [sandbox credentials](https://developer.pesapal.com/api3-demo-keys.txt), and as such the request is not mocked. This ensures the stability of the package. Where it is impossible to use real credentials, the request is mocked.

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Njogu Amos](https://github.com/njoguamos)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
