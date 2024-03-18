<?php

use NjoguAmos\Pesapal\Enums\IpnType;
use NjoguAmos\Pesapal\Requests\CreatePesapalIpn;

it(description: 'returns correct endpoint', closure: function () {
    $request = new CreatePesapalIpn(url: fake()->url, ipnType: IpnType::GET);

    expect(value: $request->resolveEndpoint())->toBe(expected: '/api/URLSetup/RegisterIPN');
});

it(description: 'forms the correct request body', closure: function () {
    $url = fake()->url;

    $request = new CreatePesapalIpn(url: $url, ipnType: IpnType::GET);

    expect(value: $request->body()->get(key: 'url'))->toBe(expected: $url)
        ->and(value: $request->body()->get(key: 'ipn_notification_type'))->toBe(expected: IpnType::GET->name);
});
