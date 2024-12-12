<?php

use NjoguAmos\Pesapal\DTOs\PesapalAddressData;
use NjoguAmos\Pesapal\DTOs\PesapalOrderData;
use NjoguAmos\Pesapal\Enums\ISOCurrencyCode;
use NjoguAmos\Pesapal\Enums\IpnType;
use NjoguAmos\Pesapal\Enums\RedirectMode;
use NjoguAmos\Pesapal\Enums\TransactionStatus;
use NjoguAmos\Pesapal\Enums\TransactionStatusCode;
use NjoguAmos\Pesapal\Models\PesapalIpn;
use NjoguAmos\Pesapal\Models\PesapalToken;
use NjoguAmos\Pesapal\Pesapal;

it(description: 'can create access token and save to database', closure: function () {
    Pesapal::createToken();

    expect(value: PesapalToken::count())->toBe(expected: 1);
});

it(description: 'can create Instant Payment Notification and save to database', closure: function () {
    Pesapal::createToken();

    Pesapal::createIpn(
        url: fake()->url,
        ipnType: IpnType::GET,
    );

    expect(value: PesapalIpn::count())->toBe(expected: 1);
});

it(description: 'can get a list of Instant Payment Notifications', closure: function () {
    Pesapal::createToken();

    Pesapal::createIpn(
        url: fake()->url,
        ipnType: IpnType::GET,
    );

    $response = Pesapal::getIpns();

    // For some reason, the response is empty on sandbox environment
    // TODO: Refactor this test to use a mock response
    expect(value: $response)->toBeEmpty();
});

it(description: 'can create an order', closure: function () {
    Pesapal::createToken();

    Pesapal::createIpn(
        url: fake()->url,
        ipnType: IpnType::GET,
    );

    $orderData = new PesapalOrderData(
        id: fake()->uuid(),
        currency: ISOCurrencyCode::KES,
        amount: 10.0,
        description: 'Test order',
        callbackUrl: fake()->url(),
        notificationId: PesapalIpn::latest()->first()->ipn_id,
        cancellationUrl: fake()->url(),
        redirectMode: RedirectMode::PARENT_WINDOW,
    );

    $billingAddress = new PesapalAddressData(phoneNumber: '0700325008');

    $order = Pesapal::createOrder(
        orderData: $orderData,
        billingAddress: $billingAddress,
    );

    expect(value: $order['order_tracking_id'])->not->toBeEmpty()
    ->and(value: $order['merchant_reference'])->not->toBeEmpty()
    ->and(value: $order['redirect_url'])->not->toBeEmpty()
    ->and(value: $order['error'])->toBeNull()
    ->and(value: $order['status'])->toBe(expected: '200');
});

it(description: 'can get transaction status', closure: function () {
    $callbackUrl = fake()->url();
    $amount = 10.0;
    $reference = fake()->uuid();

    Pesapal::createToken();

    Pesapal::createIpn(
        url: fake()->url,
        ipnType: IpnType::GET,
    );

    $orderData = new PesapalOrderData(
        id: $reference,
        currency: ISOCurrencyCode::KES,
        amount: $amount,
        description: 'Test order',
        callbackUrl: $callbackUrl,
        notificationId: PesapalIpn::latest()->first()->ipn_id,
        cancellationUrl: fake()->url(),
        redirectMode: RedirectMode::PARENT_WINDOW,
    );

    $billingAddress = new PesapalAddressData(phoneNumber: '0700325008');

    $order = Pesapal::createOrder(
        orderData: $orderData,
        billingAddress: $billingAddress,
    );

    $trackingId = $order['order_tracking_id'];

    $transaction = Pesapal::getTransactionStatus(
        orderTrackingId: $trackingId,
    );

    expect(value: $transaction['amount'])->toBe(expected: $amount)
        ->and(value: $transaction['created_date'])->not->toBeEmpty()
    ->and(value: $transaction['payment_status_description'])->toBe(expected: TransactionStatusCode::INVALID->name)
    ->and(value: $transaction['call_back_url'])->not->toBeEmpty()
    ->and(value: $transaction['message'])->toBe(expected: "Request processed successfully")
    ->and(value: $transaction['merchant_reference'])->not->toBeEmpty()
    ->and(value: $transaction['currency'])->toBe(expected: ISOCurrencyCode::KES->name)
    ->and(value: $transaction['status_code'])->toBe(expected: TransactionStatusCode::INVALID->value)
    ->and(value: $transaction['status'])->toBe(expected: (string) TransactionStatus::INCOMPLETE->value)
    ->and(value: $transaction['payment_method'])->toBeEmpty()
    ->and(value: $transaction['description'])->toBeEmpty()
    ->and(value: $transaction['confirmation_code'])->toBeEmpty()
    ->and(value: $transaction['payment_account'])->toBeEmpty()
    ->and(value: $transaction['payment_status_code'])->toBeEmpty()
    ->and(value: $transaction['error']['error_type'])->toBe(expected: 'api_error')
    ->and(value: $transaction['error']['code'])->toBe(expected: 'payment_details_not_found')
    ->and(value: $transaction['error']['message'])->toBe(expected: 'Pending Payment');

});


test(description: 'returns live redirect url when pesapal live is true', closure: function () {
    config()->set(key: 'pesapal.pesapal_live', value: true);
    config()->set(key: 'pesapal.redirect_url.live', value: 'https://pay.pesapal.com/v3');

    $orderTrackingId = 'ABC123';

    $redirectUrl = Pesapal::getRedirectUrl(orderTrackingId: $orderTrackingId);

    expect(value: $redirectUrl)
        ->toBe(expected: 'https://pay.pesapal.com/v3?OrderTrackingId=ABC123');
});

test(description: 'returns staging redirect url when pesapal live is false', closure: function () {
    config()->set(key: 'pesapal.pesapal_live', value: false);
    config()->set(key: 'pesapal.redirect_url.staging', value: 'https://cybqa.pesapal.com/v3');

    $orderTrackingId = 'ABC123';

    $redirectUrl = Pesapal::getRedirectUrl(orderTrackingId: $orderTrackingId);

    expect(value: $redirectUrl)
        ->toBe(expected: 'https://cybqa.pesapal.com/v3?OrderTrackingId=ABC123');
});
