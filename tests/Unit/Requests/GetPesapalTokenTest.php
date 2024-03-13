<?php

use ArtisanElevated\Pesapal\Requests\CreatePesapalToken;

it(description: 'returns correct endpoint', closure: function () {
    $request = new CreatePesapalToken();

    expect(value: $request->resolveEndpoint())->toBe(expected: '/api/Auth/RequestToken');
});

it(description: 'returns default body with correct consumer key and secret', closure: function () {
    $consumerKey = fake()->sha256;
    $consumerSecret = fake()->sha256;

    config()->set(key: 'pesapal.consumer_key', value: $consumerKey);
    config()->set(key: 'pesapal.consumer_secret', value: $consumerSecret);

    $request = new CreatePesapalToken();

    expect(value: $request->body()->get(key: 'consumer_key'))->toBe(expected: $consumerKey);
    expect(value: $request->body()->get(key: 'consumer_secret'))->toBe(expected: $consumerSecret);
});

it(description: 'throws an exception when consumer key and secret are not set')->todo();
