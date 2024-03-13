<?php

use ArtisanElevated\Pesapal\Enums\IpnType;
use ArtisanElevated\Pesapal\Models\PesapalIpn;
use ArtisanElevated\Pesapal\Models\PesapalToken;
use ArtisanElevated\Pesapal\Pesapal;

it(description: 'can get access token from pesapal and save to database', closure: function () {
    Pesapal::createToken();

    expect(PesapalToken::count())->toBe(1);
});

it(description: 'can get Instant Payment Notification from pesapal and save to database', closure: function () {
    Pesapal::createToken();

    Pesapal::createIpn(
        url: fake()->url,
        ipnType: IpnType::GET,
    );

    expect(PesapalIpn::count())->toBe(1);
});
