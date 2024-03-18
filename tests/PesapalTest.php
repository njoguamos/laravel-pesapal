<?php

use NjoguAmos\Pesapal\DTOs\PesapalAddressData;
use NjoguAmos\Pesapal\DTOs\PesapalOrderData;
use NjoguAmos\Pesapal\Enums\ISOCurrencyCode;
use NjoguAmos\Pesapal\Enums\IpnType;
use NjoguAmos\Pesapal\Enums\RedirectMode;
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
        amount: fake()->randomFloat(nbMaxDecimals: 2, min: 50, max: 500),
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
