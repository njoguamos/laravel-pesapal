> **warning** This package is still under development and is not ready for use in production. Please do not use it in production until this warning is removed.

![](https://banners.beyondco.de/Laravel%20Pesapal.png?theme=light&packageManager=composer+require&packageName=njoguamos%2Flaravel-pesapal&pattern=rain&style=style_2&description=A+Laravel+package+for+interacting+with+https%3A%2F%2Fwww.pesapal.com+api&md=1&showWatermark=0&fontSize=100px&images=https%3A%2F%2Flaravel.com%2Fimg%2Flogomark.min.svg)

# Laravel 10+ package for interacting with Pesapal API

[![Latest Version on Packagist](https://img.shields.io/packagist/v/njoguamos/laravel-pesapal.svg?style=flat-square)](https://packagist.org/packages/njoguamos/laravel-pesapal)
![GitHub Actions Test Status](https://img.shields.io/github/actions/workflow/status/njoguamos/laravel-pesapal/run-tests.yml?logo=github&label=Tests)
![GitHub Actions Workflow Status](https://img.shields.io/github/actions/workflow/status/njoguamos/laravel-pesapal/fix-php-code-style-issues.yml?logo=github&label=Code%20Style)
![GitHub Actions PHPStan Status](https://img.shields.io/github/actions/workflow/status/njoguamos/laravel-pesapal/phpstan.yml?logo=github&label=PHPStan)
[![Total Downloads](https://img.shields.io/packagist/dt/njoguamos/laravel-pesapal.svg?style=flat-square)](https://packagist.org/packages/NjoguAmos/laravel-pesapal)

- [] TODO: Add a description of the package

## Support us

- [] TODO: Add a link to the support page

## Why use this package
- To provide a way of generating Pesapal api `access_token` which normally expires after 5 minutes
- Offer a gateway to interacting with Pesapal v3 API

## Installation

You can install the package via composer:

```bash
composer require njogamos/laravel-pesapal
```

This packages comes with the following tables
- `pesapal_tokens` - to store the `access_token` and `expires_at` for the Pesapal API
- `pesapal_ipns` - to store the Instant Payment Notifications

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


### 1. Generate `access_token`

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
        $schedule->command('model:prune')->everyFiveMinutes();
    }
}
```

```php
 # Laravel 11 -> routes/console.php
Schedule::call('pesapal:auth')->everyFourMinutes();
Schedule::call('model:prune')->everyFiveMinutes();
```

You can also call the `createToken' in `Pesapal` class directly to generate the `access_token`. The method will return null or an new `PesapalToken` instance.

```php
use NjoguAmos\Pesapal\Pesapal;

$token = Pesapal::createToken();

// $token in an Instance of PesapalToken Eloquent Model
$data = $token->toArray();
````

Sample output

```php
[
 'access_token' => "eyJhbGciOiJIUzI1NiIs...6pVj1_DS37ghMGQ",
 'expires_at' => Carbon\Carbon instance
]
```

### 2. Create Instant Payment Notification

To create an instant payment notification, you can use the `createIpn` method in the `Pesapal` class. The method will return an instance of `PesapalIpn` or null if the request fails.

> **info** Ensure that that your `pesapal_tokens` table as an `access_token` that is not expired.

```php
use NjoguAmos\Pesapal\Pesapal;

$ipn = Pesapal::createIpn(
    url: 'https://www.yourapp.com/ipn',
    ipnType: IpnType::GET,
);

// $ipn is an Instance of PesapalIpn Eloquent Model
$data = $ipn->toArray();
````

Sample output

```php
[
    'url' => 'https://www.yourapp.com/ipn'
    'ipn_id' => 'e32182ca-0983-4fa0-91bc-c3bb813ba750'
    'type' => 'GET'
    'status' => 'Active'
]
```

> **info** The url should be a public url that can be accessed by pesapal.com. The `ipnType` can be either `IpnType::GET` or `IpnType::POST`.

You can go ahead and use the `ipn_id` to submit a Submit Order Requests.

> **info** Ensure that that your `pesapal_tokens` table as an `access_token` that is not expired. Of course, if you scheduled the `pesapal:auth` command, you should not worry about the `access_token` being expired.


### 3. Get Registered IPNs Endpoint

There are two ways to get the registered IPNs. 

1. You can use the `getIpns` method in the `Pesapal` class to get a IPN from Pesapal API.

```php
use NjoguAmos\Pesapal\Pesapal;

$response = Pesapal::getIpns();
```

```json
[
    {
        "url": "https://www.myapplication.com/ipn",
        "created_date": "2022-03-03T17:29:03.7208266Z",
        "ipn_id": "e32182ca-0983-4fa0-91bc-c3bb813ba750",
        "error": null,
        "status": "200"
    },
    {
        "url": "https://ipn.myapplication.com/application2",
        "created_date": "2021-12-05T04:23:45.5509243Z",
        "ipn_id": "c3bb813ba750-0983-4fa0-91bc-e32182ca",
        "error": null,
        "status": "200"
    }
]
```

2. or get the IPNs from the database.

```php
use NjoguAmos\Pesapal\Models\PesapalIpn;

$ips = PesapalIpn::all();
```

```php
[ 
    [
    "id" => 1
    "url" => "http://kautzer.com/omnis-ut-qui-illo-id-laborum-numquam"
    "ipn_id" => "767e3275-d504-41a0-920a-dd752aafb5ac"
    "type" => 0
    "status" => 1
    "created_at" => "2024-03-18T08:10:32.000000Z"
    "updated_at" => "2024-03-18T05:10:32.000000Z"
  ],
  [
    "id" => 2
    "url" => "http://www.cole.org/qui-fugiat-accusamus-molestiae-aspernatur-sequi-eum-non-quae.html"
    "ipn_id" => "de07604f-c06b-4ccf-9cb5-dd75aaaff99f"
    "type" => 0
    "status" => 1
    "created_at" => "2024-03-18T08:10:33.000000Z"
    "updated_at" => "2024-03-18T05:10:33.000000Z"
  ]
]
```


### 4. Submit Order Request Endpoint

To submit an order request, you can use the `createOrder` method in the `Pesapal` class. You will need to construct a DTO for `PesapalOrderData` and `PesapalAddressData` as shown below.

> **info** You must provide a registered `PesapalIpn`.


```php
use NjoguAmos\Pesapal\Enums\ISOCountryCode;
$ipnId = PesapalIpn::latest()->first()->ipn_id;

 $orderData = new PesapalOrderData(
    id: fake()->uuid(),
    currency: ISOCurrencyCode::KES,
    amount: fake()->randomFloat(nbMaxDecimals: 2, min: 50, max: 500),
    description: 'Test order',
    callbackUrl: fake()->url(),
    notificationId: $ipnId,
    cancellationUrl: fake()->url(),
    redirectMode: RedirectMode::PARENT_WINDOW,
);

// All fields are optional except either phoneNumber or emailAddress
$billingAddress = new PesapalAddressData(
    phoneNumber: '0700325008',
    emailAddress: 'test@xample.com',
    countryCode: ISOCountryCode::KE
    firstName: 'Amos', 
    middleName: 'Njogu'
//    lastName: ''
    line2: "Gil House, Nairobi, Tom Mboya Street",
//    city: "",
//    state: "",
//    postalCode: "",
//    zipCode: "",
);

$order = Pesapal::createOrder(
    orderData: $orderData,
    billingAddress: $billingAddress,
);
```

If the response was successful, your response should be as follows.

```php
[
    "order_tracking_id" => "b945e4af-80a5-4ec1-8706-e03f8332fb04",
    "merchant_reference" => "TEST1515111119",
    "redirect_url" => "https://cybqa.pesapal.com/pesapaliframe/PesapalIframe3/Index/?OrderTrackingId=b945e4af-80a5-4ec1-8706-e03f8332fb04",
    "error" => null,
    "status" => "200"
]
```

You can now re-direct the user to the `redirect_url` to complete the payment.

## Testing

> **Info** Where possible, the tests uses real [sandbox credentials](https://developer.pesapal.com/api3-demo-keys.txt), and as such the request is not mocked. This ensures the stability of the package. Where it is impossible to use real credentials, the request is mocked. Therefore you must be connected to the internet to run the some of the tests.

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
