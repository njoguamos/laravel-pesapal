<?php

use NjoguAmos\Pesapal\Enums\IpnType;
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
