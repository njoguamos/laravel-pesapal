> **warning** This package is still under development and is not ready for use in production. Please do not use it in production until this warning is removed.

# A Laravel package for interacting with https://www.pesapal.com api

[![Latest Version on Packagist](https://img.shields.io/packagist/v/artisanelevated/laravel-pesapal.svg?style=flat-square)](https://packagist.org/packages/artisanelevated/laravel-pesapal)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/artisanelevated/laravel-pesapal/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/artisanelevated/laravel-pesapal/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/artisanelevated/laravel-pesapal/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/artisanelevated/laravel-pesapal/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/artisanelevated/laravel-pesapal.svg?style=flat-square)](https://packagist.org/packages/artisanelevated/laravel-pesapal)

- [] TODO: Add a description of the package

## Support us

- [] TODO: Add a link to the support page

## Installation

You can install the package via composer:

```bash
composer require artisanelevated/laravel-pesapal
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="laravel-pesapal-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="laravel-pesapal-config"
```

This is the contents of the published config file:

```php
return [
];
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="laravel-pesapal-views"
```

## Usage

```php
$pesapal = new ArtisanElevated\Pesapal();
echo $pesapal->echoPhrase('Hello, ArtisanElevated!');
```

## Testing

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
