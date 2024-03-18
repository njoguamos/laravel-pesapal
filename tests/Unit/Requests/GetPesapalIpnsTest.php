<?php

use NjoguAmos\Pesapal\Requests\GetPesapalIpns;

it(description: 'returns correct endpoint', closure: function () {
    $request = new GetPesapalIpns();

    expect(value: $request->resolveEndpoint())->toBe(expected: '/api/URLSetup/GetIpnList');
});
