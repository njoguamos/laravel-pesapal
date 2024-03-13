<?php

use ArtisanElevated\Pesapal\Connectors\PesapalConnector;
use ArtisanElevated\Pesapal\Models\PesapalToken;

it(description: 'sets `Bearer token` authentication header from database` ', closure: function () {
    $token = PesapalToken::factory()->create();

    $connector = new PesapalConnector();

    expect(value: $connector->getAuthenticator()->token)->toBe(expected: $token->access_token)
    ->and(value: $connector->getAuthenticator()->prefix)->toBe(expected: 'Bearer');
});

it(description: 'throws an exception when token is empty')->todo();
it(description: 'throws an exception when token is expired')->todo();
