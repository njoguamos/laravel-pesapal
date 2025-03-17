![](https://banners.beyondco.de/Laravel%20Pesapal.png?theme=light&packageManager=composer+require&packageName=njoguamos%2Flaravel-pesapal&pattern=rain&style=style_2&description=A+Laravel+package+for+interacting+with+https%3A%2F%2Fwww.pesapal.com+api&md=1&showWatermark=0&fontSize=100px&images=https%3A%2F%2Flaravel.com%2Fimg%2Flogomark.min.svg)

# Laravel 11+ package for interacting with Pesapal API

[![Latest Version on Packagist](https://img.shields.io/packagist/v/njoguamos/laravel-pesapal.svg?style=flat-square)](https://packagist.org/packages/njoguamos/laravel-pesapal)
![GitHub Actions Test Status](https://img.shields.io/github/actions/workflow/status/njoguamos/laravel-pesapal/run-tests.yml?logo=github&label=Tests)
![GitHub Actions Workflow Status](https://img.shields.io/github/actions/workflow/status/njoguamos/laravel-pesapal/fix-php-code-style-issues.yml?logo=github&label=Code%20Style)
![GitHub Actions PHPStan Status](https://img.shields.io/github/actions/workflow/status/njoguamos/laravel-pesapal/phpstan.yml?logo=github&label=PHPStan)
[![Total Downloads](https://img.shields.io/packagist/dt/njoguamos/laravel-pesapal.svg?style=flat-square)](https://packagist.org/packages/NjoguAmos/laravel-pesapal)

This package provides a way of interacting with Pesapal API. It provides a way of generating `access_token` and storing Instant Payment Notifications (IPNs) in the database. It also provides a way of submitting order requests and checking the status of a transaction.


## Why use this package
- To provide a way of generating Pesapal api `access_token` which normally expires after 5 minutes
- Offer a gateway to interacting with Pesapal v3 API
- Provide a way of storing Instant Payment Notifications (IPNs) in the database
- Saves you time from writing the same code over and over again

## Playground

If you are looking to test this package, I have created a [playground](https://github.com/njoguamos/laravel-pesapal-playground) where you can test the package without having to create a new Laravel project.

## Installation

| Version | Supported Laravel |
|---------|-------------------|
| 1.x     | 10.x, 11.x        |
| 2.x     | 11.x, 12.x        |

You can install the package via composer:

```bash
composer require njoguamos/laravel-pesapal
```

This packages comes with the following tables
- `pesapal_tokens` - to store the `access_token` and `expires_at` for the Pesapal API
- `pesapal_ipns` - to store the Instant Payment Notifications

Publish and run the migrations

```bash
php artisan vendor:publish --tag="pesapal-migrations"
php artisan migrate
```

You can optionally publish the config file

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

use NjoguAmos\Pesapal\Models\PesapalToken;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule): void
    {
        # Other scheduled commands
        $schedule->command('pesapal:auth')->everyFourMinutes();
        Schedule::command('model:prune', ['--model' => [PesapalToken::class]])->everyFiveMinutes();
    }
}
```

```php
 # Laravel 11 -> routes/console.php
use Illuminate\Support\Facades\Schedule;
use NjoguAmos\Pesapal\Models\PesapalToken;

Schedule::command('pesapal:auth')->everyFourMinutes();
Schedule::command('model:prune', ['--model' => [PesapalToken::class]])->everyFiveMinutes();
```

You can also call the `createToken' in `Pesapal` class directly to generate the `access_token`. The method will return null or an new `PesapalToken` instance.

```php
use NjoguAmos\Pesapal\Pesapal;

$token = Pesapal::createToken();
````

The results of `createToken` is an instance of `PesapalToken` Eloquent Model. Which mean you can call Eloquent methods e.g.

```php
$data = $token->toArray();
```

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
````

The results of `createIpn` is an instance of `PesapalIpn` Eloquent Model. Which mean you can call Eloquent methods e.g.

```php
$data = $ipn->toArray();
```

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

1. You can use the `getIpns` method in the `Pesapal` class to get a IPN from Pesapal API.  This method returns an array for successful response or an instance of [Saloon Response](https://docs.saloon.dev/the-basics/responses) for failed response.

```php
use NjoguAmos\Pesapal\Pesapal;

$response = Pesapal::getIpns();
```

Sample successful response
```php
[
    [
        "url" => "https://www.myapplication.com/ipn",
        "created_date" => "2022-03-03T17:29:03.7208266Z",
        "ipn_id" => "e32182ca-0983-4fa0-91bc-c3bb813ba750",
        "error" => null,
        "status" => "200"
    ],
    [
        "url"=> "https://ipn.myapplication.com/application2",
        "created_date"=> "2021-12-05T04:23:45.5509243Z",
        "ipn_id"=> "c3bb813ba750-0983-4fa0-91bc-e32182ca",
        "error"=> null,
        "status"=> "200"
    ]
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

To submit an order request, you can use the `createOrder` method in the `Pesapal` class. You will need to construct a DTO for `PesapalOrderData` and `PesapalAddressData` as shown below.  This method returns an array for successful response or an instance of [Saloon Response](https://docs.saloon.dev/the-basics/responses) for failed response.

> **info** You must provide a registered `PesapalIpn`.


```php

use NjoguAmos\Pesapal\Enums\ISOCurrencyCode;
use NjoguAmos\Pesapal\Enums\ISOCountryCode;
use NjoguAmos\Pesapal\Enums\RedirectMode;
use NjoguAmos\Pesapal\Pesapal;
use NjoguAmos\Pesapal\DTOs\PesapalOrderData;
use NjoguAmos\Pesapal\DTOs\PesapalAddressData;

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

Sample successful response

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


### 5. Get Transaction Status Endpoint

You can check the status of a transaction using `OrderTrackingId` issued when creating an order. You can do so by using the `getTransactionStatus` method in the `Pesapal` class. This method returns an array for successful response or an instance of [Saloon Response](https://docs.saloon.dev/the-basics/responses) for failed response.

```php
use NjoguAmos\Pesapal\Pesapal;

 $transaction = Pesapal::getTransactionStatus(
    orderTrackingId: 'b945e4af-80a5-4ec1-8706-e03f8332fb04',
);

// $transaction either an array or an instance of Saloon Response
```

Sample successful response
```php
[
  "payment_method" => "MpesaKE"
  "amount" => 6.0
  "created_date" => "2024-03-19T20:08:46.39"
  "confirmation_code" => "SCJ8JQ26SW"
  "order_tracking_id" => "af2234da-03ee-4b60-b2dd-dd746bcda1bd"
  "payment_status_description" => "Completed"
  "description" => null
  "message" => "Request processed successfully"
  "payment_account" => "2547xxx56689"
  "call_back_url" => "http://127.0.0.1:8000/pesapal-callback?OrderTrackingId=af2234da-03ee-4b60-b2dd-dd746bcda1bd&OrderMerchantReference=1"
  "status_code" => 1
  "merchant_reference" => "1"
  "payment_status_code" => ""
  "currency" => "KES"
  "error" => [
    "error_type" => null
    "code" => null
    "message" => null
  ]
  "status" => "200"
]
```

### 6. Recurring / Subscription Based Payments
- [ ] TODO: Add documentation for recurring payments

### 7. Refund Request
- [ ] TODO: Add documentation for refund request

### 8. Retrying Requests

If for some reason, the payment did not complete and you have the order tracking ID, you can retry the payment by redirecting the user to the Pesapal payment page.

```php
use NjoguAmos\Pesapal\Pesapal;

$redirectUrl = Pesapal::getRedirectUrl(orderTrackingId: $orderTrackingId);
// https://pay.pesapal.com/iframe/PesapalIframe3/Index?OrderTrackingId=db80f574-a759-40b3-a6ec-dc68ef3dc1e6
```

## A note about responses

For flexibility and simplicity, the `Pesapal` static method returns an `array` for successful responses or an instance of `Saloon Response` for failed responses.

Example, when getting the transaction status using `getTransactionStatus` will either return an array of transaction details or an instance of `Saloon Response` if the request was not successful.

```php
use NjoguAmos\Pesapal\Pesapal;

 $transaction = Pesapal::getTransactionStatus(
    orderTrackingId: 'b945e4af-80a5-4ec1-8706-e03f8332fb04',
);

if (is_array($transaction)) {
    // The API call was successful and response is an array
    //    [
    //      "payment_method" => "MpesaKE"
    //      "amount" => 6.0
    //      "created_date" => "2024-03-19T20:08:46.39"
    //      "confirmation_code" => "SCJ8JQ26SW"
    //      "....more field"
    //    ]
} else {
    // The API call was not successful. The response is an instance of Saloon Response
    // $transaction->status() ---> response status code.
    // $transaction->headers() ---> Returns all response headers
    // $transaction->getPendingRequest() ---> PendingRequest class that was built up for the request.
}
```

You can learn more about the [Saloon Response(https://docs.saloon.dev/the-basics/responses). You can use the response to diagnose the issue with the request.

## Testing

> **Info** Where possible, the tests uses real [sandbox credentials](https://developer.pesapal.com/api3-demo-keys.txt), and as such the request is not mocked. The resulting response is saved at `tests/Fixtures` and used in future tests. Where it is impossible to use real credentials, the request is mocked. You can recreate the fixtures by deleting `tests/Fixtures` and running the tests.

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
