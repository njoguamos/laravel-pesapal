<?php

use ArtisanElevated\Pesapal\Connectors\PesapalConnector;

it(description: 'returns correct base url', closure: function (bool $mode, string $baseUrl) {
    config()->set(key: 'pesapal.pesapal_live', value: $mode);

    $connector = new PesapalConnector();

    expect(value: $connector->resolveBaseUrl())->toBe(expected: $baseUrl);
})->with([
    'live'    => [true, 'https://pay.pesapal.com/v3'],
    'staging' => [false, 'https://cybqa.pesapal.com/pesapalv3'],
]);

it(description: 'sets `Accept` header to application/json', closure: function () {
    $connector = new PesapalConnector();

    expect(value: $connector->headers()->get(key: 'Accept'))->toBe(expected: 'application/json');
});

it(description: 'sets `Content-Type` header to application/json', closure: function () {
    $connector = new PesapalConnector();

    expect(value: $connector->headers()->get(key: 'Content-Type'))->toBe(expected: 'application/json');
});

it(description: 'throws an exception when invalid live mode is provided')->todo();
